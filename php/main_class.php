<?php
require_once('C:\xampp\htdocs\FYP\php\defines.php');

class Main
{

    public function get_Profile($username)
    {

        $con = connectTo();
        $stmt = $con->prepare("SELECT * FROM `Lecturer` WHERE `Username` = :username");
        $stmt->bindValue(":username", $username);
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();

        $rows = $stmt->fetchAll();

        if (count($rows) == 0) {
            $con = null;
            respond("error", "not_found");
        } else {
            foreach ($rows as $row) {
                // START SESSION

                $_SESSION['lec_id'] = $row['LecID'];
                $_SESSION['title'] = $row['Title'];
                $_SESSION['name'] = $row['offName'];
                $_SESSION['email'] = $row['Email'];
                $_SESSION['phone'] = $row['Phone'];
                $_SESSION['dept'] = $row['Dept'];
                $_SESSION['image'] = $row['Image'];

                session_write_close();
            }
        }
    }

    public function get_Profile2($username)
    {

        $con = connectTo();
        $stmt = $con->prepare("SELECT * FROM `Admin` WHERE `Username` = :username");
        $stmt->bindValue(":username", $username);
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();

        $rows = $stmt->fetchAll();

        if (count($rows) == 0) {
            $con = null;
            respond("error", "not_found");
        } else {
            foreach ($rows as $row) {
                // START SESSION

                $_SESSION['admin_id'] = $row['AdminID'];
                $_SESSION['title'] = $row['Title'];
                $_SESSION['name'] = $row['Name'];
                $_SESSION['email'] = $row['Email'];
                $_SESSION['phone'] = $row['Phone'];
                $_SESSION['dept'] = $row['Dept'];
                $_SESSION['image'] = $row['Image'];

                session_write_close();

            }
        }
    }

    public function phpAlert($msg, $page)
    {
        echo '<script type="text/javascript">
               alert("' . $msg . '");
               window.location.href = "  ' . $page . ' ";   
              </script>';
    }

    //debug helper function to print to console

    function debug_to_console($data)
    {
        $output = $data;

        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

    public function get_Classes($lec_id)
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT C.ClassID,C.className,C.totalClasses,A.Semester,A.Day,A.Description,A.Start_Time,A.End_Time,A.Duration
                                         FROM Class AS C 
                                         INNER JOIN Assigned_classes AS A 
                                         ON C.ClassID = A.ClassID
                                         WHERE A.LecID = :lec_id
                                         ORDER BY A.Start_Time;");

        $stmt->bindValue(":lec_id", $lec_id);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();

        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;

    }

    public function getClass()
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT Cl.ClassID, Cl.className, Cl.totalClasses, Cl.totalHours
                                         FROM Class AS Cl
                                         ORDER BY Cl.ClassID");
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;

    }

    public function getCourse()
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT *
                                         FROM Course
                                         ");
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;

    }
    public function getCtoC(){
        $con = connectTo();
        $stmt = $con->prepare("SELECT *
                                         FROM Class_Course
                                         ");
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;
    }

    public function getStud()
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT * FROM `Student`");
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;

    }

    public function getAss()
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT * FROM `Assigned_classes`");
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;

    }

    public function getLec()
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT L.LecID,L.offName,L.Dept,L.Username,L.Email,L.Password,L.Type 
                                         FROM Lecturer AS L
                                         ORDER BY L.LecID");
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;

    } //lectable

    public function num_Classes($lec_id)
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT C.ClassID,C.className,C.totalClasses,A.Semester,A.Day,A.Description,A.Start_Time,A.End_Time,A.Duration
                                         FROM Class AS C 
                                         INNER JOIN Assigned_classes AS A 
                                         ON C.ClassID = A.ClassID
                                         WHERE A.LecID = :lec_id
                                         ORDER BY A.Start_Time;");
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $stmt->bindValue(":lec_id", $lec_id);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();

        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        $_SESSION['rowno'] = count($rows);

        session_write_close();

    }

    public function updateDesc($class_id, $message)
    {
        $con = connectTo();
        $stmt = $con->prepare("UPDATE Assigned_classes SET Description =  :description
                                                WHERE ClassID = :id");
        $stmt->bindValue(":description", $message);
        $stmt->bindValue(":id", $class_id);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $this->phpAlert("updated successfully!", "../class.php");

    }

    public function updateLec($id, $name, $dept, $email, $uname, $pass)
    {
        $con = connectTo();
        $stmt = $con->prepare("UPDATE Lecturer SET offName = :name,
                                                             Dept = :dept,
                                                             Email = :email,
                                                             Username = :uname,
                                                             Password = :pass
                                                WHERE LecID = :id");
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":dept", $dept);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":uname", $uname);
        $stmt->bindValue(":pass", $pass);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();

    } //edit profile dialog lec_tools

    public function updateStud($id, $name, $sem, $email, $course, $phone)
    {
        $con = connectTo();
        $stmt = $con->prepare("UPDATE Student SET Name = :name,
                                                            Semester = :sem,
                                                            Email = :email,
                                                            Course = :course,
                                                            Phone = :phone
                                                WHERE StudentID = :id");
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":sem", $sem);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":course", $course);
        $stmt->bindValue(":phone", $phone);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
    }

    public function updateClass($id, $name, $t_hrs, $course, $t_class)
    {
        $con = connectTo();
        $stmt = $con->prepare("UPDATE Class SET className = :name,
                                                          totalClasses = :class,
                                                          totalHours = :hrs,
                                                          CourseID = :c
                                                WHERE ClassID = :id");
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":class", $t_class);
        $stmt->bindValue(":hrs", $t_hrs);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":c", $course);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();

    }

    public function getStudents($class_id)
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT S.Name,S.StudentID
                                         FROM Student AS S
                                         INNER JOIN Class AS C 
                                         ON C.CourseID = S.CourseID
                                         WHERE C.ClassID = :class_id
                                         ORDER BY S.Name;");
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $stmt->bindValue(":class_id", $class_id);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;

    }

    public function getStudents2($class_id)
    {
        $con = connectTo();
        $stmt2 = $con->prepare( "Select Semester from Assigned_classes where ClassID = :class");
        $stmt2->bindValue(":class", $class_id);
        if (!$stmt2) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $stmt2->execute();
        $sem2 = $stmt2->fetchAll();
        $sem='';
        foreach ($sem2 as $row){
            $sem = $row['Semester'];
        }
        $this->debug_to_console("Semester for class: ".$sem);


        $stmtx = $con->prepare( "Select * from Class_Course where ClassID = :class");
        $stmtx->bindValue(":class", $class_id);
        if (!$stmtx) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $stmtx->execute();
        $rows = $stmtx->fetchAll();
        $this->debug_to_console("courses assigned to this class:".count($rows));

        foreach ($rows as $row){
            $stmt = $con->prepare("SELECT S.Name,S.StudentID
                                         FROM ((Student AS S
                                         INNER JOIN Class_Course AS C
                                         ON S.CourseID = C.CourseID)
                                         INNER JOIN Assigned_classes AS A 
                                         ON A.Semester = S.Semester)
                                         WHERE C.CourseID = :c
                                         AND A.Semester = :s
                                         ORDER BY S.Name;");
            $stmt->bindValue(":c", $row['CourseID']);
            $stmt->bindValue(":s", $sem);
            if (!$stmt) {
                echo "\nPDO::errorInfo():\n";
                print_r($con->errorInfo());
            }
            $stmt->execute();
            $rows2 = $stmt->fetchAll();
            $this->debug_to_console(count($rows2));
            if(count($rows2)==0){
                continue;
            }else{
            yield $rows2;}
        }

    }

    public function check_table($class_id)
    {
        $tname = "ClassID_" . $class_id . "_attendance";

        $con = connectTo();
        $num_tables = $con->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name='" . $tname . "'");
        $num_tables->execute();
        $tables = $num_tables->fetchAll();
        $count_t = count($tables);
        return $count_t;

    }

    public function save_attendance($tp, $status, $class_id, $totalclass)
    {
        $stats = 0;
        $class = 1;
        $tname = "ClassID_" . $class_id . "_attendance";
        $con = connectTo();

        $this->debug_to_console("not exists");
        $table = "CREATE TABLE IF NOT EXISTS " . $tname . " (
                  `StudentID` INTEGER NOT NULL UNIQUE,
                  `Classes_Attended` INTEGER DEFAULT 0,
                  `Classes_Had` INTEGER DEFAULT 0,
                  `totalClasses` INTEGER DEFAULT 0)";

        $con->exec($table);

        if ($status == 1) {
            $stats = 0;
        } elseif ($status == 2) {
            $stats = 1;
        } elseif ($status == 3) {
            $stats = 1 - (1 / 3);
        } else {
            $stats = 0.5;
        }

        $stmt = $con->prepare("INSERT INTO " . $tname . "(StudentID,Classes_Attended,Classes_Had,totalClasses)
                                                VALUES(:tp,:status,:class,:total)");
        $stmt->bindValue(":tp", $tp);
        $stmt->bindValue(":status", $stats);
        $stmt->bindValue(":class", $class);
        $stmt->bindValue(":total", $totalclass);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $done = $stmt->execute();
        if ($done == true) {
            $this->debug_to_console("Records saved successfully!");
        } else {
            $this->phpAlert("Error saving records, please seek technical assistance! Redirecting you to main page...", "../class.php");
        }

    }

    public function save_attendance2($tp, $status, $class_id)
    {
        $stats = 0;
        $tname = "ClassID_" . $class_id . "_attendance";
        $con = connectTo();

        $this->debug_to_console("exists");

        if ($status == 1) {
            $stats = 0;
        } elseif
        ($status == 2) {
            $stats = 1;
        } elseif
        ($status == 3) {
            $stats = 1 - (2 / 3);
        } else {
            $stats = 0.5;
        }

        $stmt = $con->prepare("SELECT Classes_Had,totalClasses FROM `{$tname}` WHERE StudentID = :tp");
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->bindValue(":tp", $tp);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();

        $rows = $stmt->fetchAll();
        if (count($rows) == 0) {
            $con = null;
            respond("error", "not_found");
        } else {
            foreach ($rows as $row) {
                $had = $row['Classes_Had'];
                $total = $row['totalClasses'];

                if ($had == $total) {
                    $this->phpAlert("Error: Classes have exceeded specified limit :" . $total . ", please seek technical assistance! Redirecting you to main page...", "../class.php");
                }
            }

            $stmtx = $con->prepare("UPDATE `{$tname}` SET Classes_Attended = Classes_Attended + {$stats},
                                                                  Classes_Had = Classes_Had + 1
                                                                  WHERE StudentID = :tp");
            if (!$stmtx) {
                echo "\nPDO::errorInfo():\n";
                print_r($con->errorInfo());
            }

            $stmtx->bindValue(":tp", $tp);


            if (!$stmtx) {
                echo "\nPDO::errorInfo():\n";
                print_r($con->errorInfo());
            }

            $done = $stmtx->execute();
            if ($done == true) {
                $this->debug_to_console("Records saved successfully!");
            } else {
                $this->phpAlert("Error saving records, please seek technical assistance! Redirecting you to main page...", "../class.php");
            }
        }

    }

    public function addLec($dept, $name, $email, $title, $username, $pass, $type)
    {
        $con = connectTo();
        $stmt = $con->prepare("INSERT INTO `Lecturer`(Title,offName,Dept,Username,Email,Password,Type)
                                                VALUES(:title,:name,:dept,:uname,:email,:pass,:type)");
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":dept", $dept);
        $stmt->bindValue(":uname", $username);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":pass", $pass);
        $stmt->bindValue(":type", $type);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $done = $stmt->execute();

        if ($done == true) {
            $this->phpAlert("Records Saved Successfully!", "../lec_tools.php");
        } else {
            $this->phpAlert("Error saving records, please seek technical assistance! Redirecting you to main page...", "../lec_tools.php");
        }

    } //new lec

    public function addStud($name, $email, $phone, $course)
    {
        $con = connectTo();
        $stmt = $con->prepare("INSERT INTO `Student`(Name,Course,Phone,Email)
                                                VALUES(:name,:course,:phone,:email)");
        $stmt->bindValue(":course", $course);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":phone", $phone);
        $stmt->bindValue(":email", $email);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $done = $stmt->execute();

        if ($done == true) {
            $this->phpAlert("Records Saved Successfully!", "../stud_tools.php");
        } else {
            $this->phpAlert("Error saving records, please seek technical assistance! Redirecting you to main page...", "../stud_tools.php");
        }

    }

    public function addClass($name, $hrs, $cid, $class)
    {
        $con = connectTo();
        $stmt = $con->prepare("INSERT INTO `Class`(className,totalClasses,totalHours,CourseID)
                                                VALUES(:name,:class,:hrs,:cid)");
        $stmt->bindValue(":cid", $cid);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":class", $class);
        $stmt->bindValue(":hrs", $hrs);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $done = $stmt->execute();

        if ($done == true) {
            $this->phpAlert("Records Saved Successfully!", "../class_tools.php");
        } else {
            $this->phpAlert("Error saving records, please seek technical assistance! Redirecting you to main page...", "../class_tools.php");
        }

    }

    public function addCourse($name, $dept)
    {
        $con = connectTo();
        $stmt = $con->prepare("INSERT INTO `Course`(Course_Name,Department)
                                                VALUES(:name,:dept)");
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":dept", $dept);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $done = $stmt->execute();

        if ($done == true) {
            $this->phpAlert("Records Saved Successfully!", "../class_tools.php");
        } else {
            $this->phpAlert("Error saving records, please seek technical assistance! Redirecting you to main page...", "../class_tools.php");
        }

    }

    public function addC2C($cl, $co)
    {
        $con = connectTo();
        $stmt = $con->prepare("INSERT INTO `Class_Course`(ClassID,CourseID)
                                                VALUES(:class,:cour)");
        $stmt->bindValue(":class", $cl);
        $stmt->bindValue(":cour", $co);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $done = $stmt->execute();

        if ($done == true) {
            $this->phpAlert("Records Saved Successfully!", "../class_tools.php");
        } else {
            $this->phpAlert("Error saving records, please seek technical assistance! Redirecting you to main page...", "../class_tools.php");
        }

    }

    public function getLec_Det($id)
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT * FROM `Lecturer` WHERE LecID = :id ");
        $stmt->bindValue(":id", $id);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;
    } //autofill edit dialog

    public function getStud_Det($id)
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT * FROM `Student` WHERE StudentID = :id ");
        $stmt->bindValue(":id", $id);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;
    }

    public function getStud_Card($id)
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT * FROM `Student` WHERE StudentID = :id ");
        $stmt->bindValue(":id", $id);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;
    }

    public function getClass_Det($id)
    {
        $con = connectTo();
        $stmt = $con->prepare("SELECT * FROM `Class` WHERE ClassID = :id ");
        $stmt->bindValue(":id", $id);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();
        $this->debug_to_console(count($rows));
        return $rows;
    }

    public function searchClass($class, $lec)
    {
        $con = connectTo();
        $exists = $con->prepare("SELECT ClassID FROM `Class` WHERE `ClassID` = :class");
        $exists->bindValue(":class", $class);

        if (!$exists) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $exists->execute();
        $rows = $exists->fetchAll();

        if (count($rows) == 0) {
            $con = null;
            respond("error", "not_found");
        } else {
            $exists2 = $con->prepare("SELECT * FROM `Assigned_classes` WHERE `ClassID` = :class AND `LecID` = :lec");
            $exists2->bindValue(":class", $class);
            $exists2->bindValue(":lec", $lec);

            if (!$exists2) {
                echo "\nPDO::errorInfo():\n";
                print_r($con->errorInfo());
            }

            $exists2->execute();
            $rows = $exists2->fetchAll();

            if (count($rows) == 0) {
                $_SESSION['class'] = $class;
                session_write_close();
                die(json_encode(array("error" => "found", "session" => $_SESSION)));
            } else {
                $_SESSION['class'] = $class;
                session_write_close();
                //respond("error", "none");
                die(json_encode(array("error" => "none", "session" => $_SESSION)));
                //die(json_encode(array("error" => "none")));
            }
        }
    }

    public function searchAtt($class, $stud)
    {
        $con = connectTo();
        $exists = $con->prepare("SELECT ClassID FROM `Class` WHERE `ClassID` = :class");
        $exists->bindValue(":class", $class);

        if (!$exists) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $exists->execute();
        $rows = $exists->fetchAll();

        if (count($rows) == 0) {
            $con = null;
            respond("error", "non_exist");
        } else {
            $tname = "ClassID_" . $class . "_attendance";

            $num_tables = $con->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name='" . $tname . "'");
            $num_tables->execute();
            $tables = $num_tables->fetchAll();
            $count_t = count($tables);
            if($count_t == 0){
                respond("error", "not_found");
            }
            else {

                $stmt = $con->prepare("SELECT Classes_Had,Classes_Attended FROM `{$tname}` WHERE StudentID = :tp");

                $stmt->bindValue(":tp", $stud);

                if (!$stmt) {
                    echo "\nPDO::errorInfo():\n";
                    print_r($con->errorInfo());
                }

                $stmt->execute();
                $rows = $stmt->fetchAll();
                if (count($rows) == 0) {
                    $con = null;
                    respond("error", "found");
                } else {
                    foreach ($rows as $row) {
                        $_SESSION['attend'] = $row['Classes_Attended'];
                        $_SESSION['hadd'] = $row['Classes_Had'];
                        $_SESSION['class1'] = $class;

                        session_write_close();
                        die(json_encode(array("error" => "none", "session" => $_SESSION)));
                    }
                }
            }
        }
    }

    public function searchClass2($class, $lec)
    {
        $con = connectTo();

        $exists2 = $con->prepare("SELECT * FROM `Assigned_classes` WHERE `ClassID` = :class AND `LecID` = :lec");
        $exists2->bindValue(":class", $class);
        $exists2->bindValue(":lec", $lec);

        if (!$exists2) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $exists2->execute();
        $rows = $exists2->fetchAll();
        return $rows;
    }

    public function updateAssigned($lec, $class, $sem, $day, $start, $end, $dura)
    {
        $con = connectTo();
        $stmtx = $con->prepare("SELECT * FROM `Assigned_classes` WHERE ClassID = :class");
        $stmtx->bindValue(":class", $class);
        if (!$stmtx) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $stmtx->execute();
        $rows = $stmtx->fetchAll();

        if (count($rows) == 0) {

            $stmt = $con->prepare("INSERT INTO `Assigned_classes`(LecID,ClassID,Semester,Day,Start_Time,End_Time,Duration)
                                              VALUES(:lec,:class,:sem,:day,:start,:endt,:dura)");
            $stmt->bindValue(":lec", $lec);
            $stmt->bindValue(":class", $class);
            $stmt->bindValue(":sem", $sem);
            $stmt->bindValue(":day", $day);
            $stmt->bindValue(":start", $start);
            $stmt->bindValue(":endt", $end);
            $stmt->bindValue(":dura", $dura);

            if (!$stmt) {
                echo "\nPDO::errorInfo():\n";
                print_r($con->errorInfo());
            }
            $stmt->execute();

            die(json_encode(respond("error", "none")));

        } else {
            $stmt = $con->prepare("UPDATE Assigned_classes SET LecID = :lec,
                                                                 Semester = :sem,
                                                                 Day = :day,
                                                                 Start_Time = :start,
                                                                 End_Time = :endt,
                                                                 Duration = :dura
                                                    WHERE ClassID = :class");
            $stmt->bindValue(":lec", $lec);
            $stmt->bindValue(":class", $class);
            $stmt->bindValue(":sem", $sem);
            $stmt->bindValue(":day", $day);
            $stmt->bindValue(":start", $start);
            $stmt->bindValue(":endt", $end);
            $stmt->bindValue(":dura", $dura);

            if (!$stmt) {
                echo "\nPDO::errorInfo():\n";
                print_r($con->errorInfo());
            }

            $stmt->execute();

            die(json_encode(respond("error", "none")));
        }

    }

    public function updateAtt($lec,$class,$att){
        $con = connectTo();
        $tname = "ClassID_" . $class . "_attendance";

        $stmt = $con->prepare("UPDATE `{$tname}` SET Classes_Attended = :att
                                                WHERE StudentID = :id");
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->bindValue(":id", $lec);
        $stmt->bindValue(":att", $att);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $stmt->execute();
        die(json_encode(respond("error", "none")));
    }

    public function deleteLec($lec)
    {
        $con = connectTo();
        $stmt = $con->prepare("DELETE FROM Lecturer WHERE LecID = :lec");
        $stmt->bindValue(":lec", $lec);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $stmt->execute();
        return;
    }

    public function deleteStud($lec)
    {
        $con = connectTo();
        $stmt = $con->prepare("DELETE FROM Student WHERE StudentID = :lec");
        $stmt->bindValue(":lec", $lec);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $stmt->execute();
        return;
    }

    public function deleteClass($lec)
    {
        $con = connectTo();
        $stmt = $con->prepare("DELETE FROM Class WHERE ClassID = :lec");
        $stmt->bindValue(":lec", $lec);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $stmt->execute();
        return;
    }

    public function deleteCourse($lec)
    {
        $con = connectTo();
        $stmt = $con->prepare("DELETE FROM Course WHERE CourseID = :lec");
        $stmt->bindValue(":lec", $lec);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $stmt->execute();
        return;
    }

    public function deleteCtoC($lec)
    {
        $con = connectTo();
        $stmt = $con->prepare("DELETE FROM Class_Course WHERE ClassID = :lec");
        $stmt->bindValue(":lec", $lec);

        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }
        $stmt->execute();
        return;
    }

    public function isPresent($card){
        $con = connectTo();
        $studid="";
        $exists2 = $con->prepare("SELECT StudentID FROM `Student` WHERE `NFC_uid` = :card");
        $exists2->bindValue(":card", $card);

        if (!$exists2) {
            echo "\nPDO::errorInfo():\n";
            print_r($con->errorInfo());
        }

        $exists2->execute();
        $rows = $exists2->fetchAll();
        //$this->debug_to_console("students with this ID:".count($rows));

        foreach ($rows as $row){
            $studid = $row['StudentID'];
        }
        return $studid;

    }

}

?>