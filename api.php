<?php
/*
	Digital ID SV APP API
*/
date_default_timezone_set('America/El_Salvador');
ini_set('memory_limit', '256M');

require_once 'classes/DB.class.php';
//connect to the database  
$db = new DB();  
$db->connect(); 
mysql_query("SET NAMES 'utf8'");

$mode = $_GET["mode"];
$id = $_GET["id"];

$final = array();
$final["code"] = "01";

/*
    users
    - register
    - login
*/

if ($mode == "users") {	

	if($id == "register"){
		
		$username = $_POST["username"];
		$password = md5($_POST["password"]);
        $phone = $_POST["phone"];
        
        $exist = $db->select('users', 'username = "'.$username.'"');

        if(!empty($exist)){
            $final["code"] = "02";
			$final["message"] = "Username already exist";
        }else{
            $code = hash('crc32b', date('YmdHis'));

            $data = array( 
                "secure_code" => "'$code'",
                "username" => "'$username'",
                "password" => "'$password'",
                "phone" => "'$phone'"
            );
            $db->insert($data, "users");
            $final["message"] = "User added successfully";
            $final["code"] = "03";
        }
    }
 
    if($id == "login"){

        $username = $_POST["username"];
        $password = md5($_POST["password"]);
        
        $exist = $db->select('users', 'username = "'.$username.'" AND password = "'.$password.'"');

        if(empty($exist)){
            $final["code"] = "02";
			$final["message"] = "Username or password incorrect";
        }else{

            $find_fragments = $db->select('users_fragments', 'id_user = '.$exist[0]["id_user"]);

            if(empty($find_fragments)){
                $fragments = 'Information not added';
            }else{
                $fragments = 'Information added';
            }

            $final["secure_code"] = $exist[0]["secure_code"];
            $final["verify_information"] = $fragments;
            $final["message"] = "Success";
            $final["code"] = "03";
        }

    }

}

/*
    entity
    - login
*/

if($mode == "entity"){
	if($id == "login"){
		$email = $_POST["email"];
		$password = md5($_POST["password"]);

		$exist = $db->select('entities', 'email = "'.$email.'" AND password = "'.$password.'"');

		if(empty($exist)){
			$final["code"] = "02";
			$final["message"] = "Email or password incorrect";
		}else{
			$final["entity"] = $exist[0]["id_entity"];
			$final["type"] = $exist[0]["id_e_type"];
			$final["message"] = "Success";
			$final["code"] = "03";
		}
	}
}

/*
    fragments
    - add
    - get
*/

if($mode == "fragments"){
	if($id == "add"){
		$secure_code = $_POST["secure_code"];
		$type = $_POST["type"];

		$data["tipo"] = $type;

		switch ($type) {
			case 1: //General

				$name = $_POST["name"];
				$lastname = $_POST["lastname"];
				$gender = $_POST["gender"];
				$birthdate = $_POST["birthdate"];

				$data["nombres"] = $name;
				$data["apellidos"] = $lastname;
				$data["genero"] = $gender;
				$data["fecha_nacimiento"] = $birthdate;

				break;

			case 2: //Tributaria

				$number = $_POST["number"];

				$data["numero"] = $number;
				
				break;

			case 3 : //Pensiones

				$manager = $_POST["manager"];
				$number = $_POST["number"];

				$data["administradora"] = $manager;
				$data["numero"] = $number;
				
				break;

			case 4: //Seguro

				$number = $_POST["number"];

				$data["numero"] = $number;
				
				break;

			case 5 : //Contacto

				$name = $_POST["name"];
				$value = $_POST["value"];

				$data["nombre"] = $name;
				$data["valor"] = $value;
				
				break;

			case 6 : //Salud

				$name = $_POST["name"];
				$value = $_POST["value"];

				$data["nombre"] = $name;
				$data["valor"] = $value;
				
				break;

			case 7: //Académica

				$level = $_POST["level"];
				$option = $_POST["option"];
				$institution = $_POST["institution"];

				$data["nivel"] = $level;
				$data["opcion"] = $option;
				$data["institucion"] = $institution;

				break;

			case 8: //Laboral

				$company = $_POST["company"];
				$position = $_POST["position"];

				$data["posicion"] = $position;
				$data["empresa"] = $company;

				break;
		}

		$fragment_hash = hash('sha256', $type.$secure_code.date('YmdHis'));

		$data["hash"] = $fragment_hash;

		$ch = curl_init();
		$headers  = ['Content-Type: application/json'];
		curl_setopt($ch, CURLOPT_URL,"http://localhost:3001/addFragment");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));           
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result     = curl_exec ($ch);
		$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$user = $db->select('users', 'secure_code = "'.$secure_code.'"');

		if(!empty($user)){
			$id_user = $user[0]["id_user"];

			$fragment_data = array('hash' => '"'.$fragment_hash.'"');
			$fragment = $db->insert($fragment_data, 'fragments');

			if($fragment){
				$user_fragment = array('id_user' => $id_user, 'id_fragment' => $fragment);

				if($db->insert($user_fragment, 'users_fragments')){
					$final["code"] = "03";
					$final["message"] = "Success";
				}
			}else{
				$final["code"] = "02";
				$final["message"] = "Error";
			}
		}else{
			$final["code"] = "02";
			$final["message"] = "Error";
		}

	}

	if($id == "get"){
		$secure_code = $_POST["secure_code"];
		$id_entity = $_POST["entity"];

		$user = $db->select('users', 'secure_code = "'.$secure_code.'"');

		if(!empty($user)){
			$id_user = $user[0]["id_user"];

			$entity = $db->select('entities', 'id_entity = '.$id_entity);

			if(!empty($entity)){

				$type = $entity[0]['id_e_type'];

				$user_fragments = $db->select('users_fragments', 'id_user = '.$id_user);

				$data = file_get_contents('http://localhost:3001/blocks');
				$decoded = json_decode($data, true);

				$info = array();
				$base = array();

				$b = 0;
				$j = 0;

				foreach ($user_fragments as $key => $value) {

					$fragments = $db->select('fragments', 'id_fragment = '.$value['id_fragment']);

					foreach ($fragments as $key => $value) {
						$hash = $value['hash'];

						for($i = 1; $i < count($decoded); $i++){
							if($type != 1 && $decoded[$i]['data'][0]['tipo'] == 1){
								$base[$b] = $decoded[$i]['data'];
								$b++;
							}
							if($decoded[$i]['data'][0]['tipo'] == $type && $decoded[$i]['data'][0]['hash'] == $hash){
								$info[$j] = $decoded[$i]['data'];
								$j++;
							}
						}
						
					}

				}

				$final["code"] = "03";
				$final["message"] = "Success";
				$final["data"] = $info;
				$final["data"]["base"] = $base;

			}else{
				$final["code"] = "02";
				$final["message"] = "Error";
			}
		}else{
			$final["code"] = "02";
			$final["message"] = "Error";
		}
	}
}

$final = json_encode($final);
echo $final;

?>