<?php
session_start();

require 'asset/connection/mysqli_dbconnection.php';

error_reporting(E_ALL | E_STRICT);
if(isset($_POST['btn_update_company']))
	{    
		$comp_id 		   =   $_POST['comp_id'];
        $comp_name         =   $_POST['comp_name'];
        $comp_desc         =   $_POST['comp_desc'];
        $comp_address      =   $_POST['comp_address'];
        $comp_city         =   $_POST['comp_city'];
        $contact_person    =   $_POST['contact_person'];
        $position          =   $_POST['position'];
        $contact_no        =   $_POST['contact_no'];
        $email             =   $_POST['email'];
        $type_industry     =   $_POST['type_industry'];
        $other_industry    =   $_POST['other_industry'];
        $comp_dept         =   $_POST['comp_dept'];
        $comp_status       =   $_POST['comp_status'];

        $type              =   $_FILES['comp_logo']['type'];

        if(!empty($type) && !empty($type_industry=='Accommodation and Food Services Activities'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

			$table 	 = "company_info";
			$columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
            			];
			$where = ["comp_id" => $comp_id];
			$q_data = $database->update($table,$columns,$where);
			header("Location: e2e_company_records.php?success1=OK");
		}
        elseif(empty($type) && !empty($type_industry=='Accommodation and Food Services Activities'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Arts, Entertainment and Recreation'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Arts, Entertainment and Recreation'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Education'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Education'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Financial and Insurance Activities'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Financial and Insurance Activities'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Human Health and Social Work Activities'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Human Health and Social Work Activities'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Information and Communication'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Information and Communication'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Professional, Scientific and Technical Activities'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Professional, Scientific and Technical Activities'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Real Estate Activities'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Real Estate Activities'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Wholesale & Retail Trade, Repair of Motor Vehicles & Motorcycles'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Wholesale & Retail Trade, Repair of Motor Vehicles & Motorcycles'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Transport and Storage'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Transport and Storage'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Administrative and Support Service Activities'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Administrative and Support Service Activities'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Public Administration and Defense, Compulsory Social Security'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Public Administration and Defense, Compulsory Social Security'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Construction'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Construction'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Electricity, Gas, Steam and Air Conditioning Supply'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Electricity, Gas, Steam and Air Conditioning Supply'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Manufacturing'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Manufacturing'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Mining and Quarrying'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Mining and Quarrying'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Water Supply, Sewerage, Waste Management and Remediation Activities'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Water Supply, Sewerage, Waste Management and Remediation Activities'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Agriculture, Forestry and Fishing'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Agriculture, Forestry and Fishing'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   '',
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(!empty($type) && !empty($type_industry=='Others'))
        {    
            $content = (file_get_contents($_FILES['comp_logo']['tmp_name']));
            $base64  = base64_encode($content);

            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   $other_industry,
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        "comp_logo"          =>   $base64,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }
        elseif(empty($type) && !empty($type_industry=='Others'))
        {    
            $table   = "company_info";
            $columns = ["comp_name"          =>   $comp_name,
                        "comp_desc"          =>   $comp_desc,
                        "comp_address"       =>   $comp_address,
                        "comp_city"          =>   $comp_city,
                        "contact_person"     =>   $contact_person,
                        "position"           =>   $position,
                        "contact_no"         =>   $contact_no,
                        "email"              =>   $email,
                        "type_industry"      =>   $type_industry,
                        "other_industry"     =>   $other_industry,
                        "comp_dept"          =>   $comp_dept,
                        "status"             =>   $comp_status,
                        ];
            $where = ["comp_id" => $comp_id];
            $q_data = $database->update($table,$columns,$where);
            header("Location: e2e_company_records.php?success1=OK");
        }			
	}
?>
