<?php 
class Section{
    public $sectionName;

    public function __construct($sectionName) {
        $this->sectionName = $sectionName;
    }
    public function getName() {
        return $this->sectionName;
    }
    // public function toJson() {
    //     $jsonString= json_encode($this->data, JSON_PRETTY_PRINT);
    //     // Return the JSON string
    //     return $jsonString;
    // }
    public static function convertJsonToListView($eq,$jsonString) {
        // Decode JSON to associative array
        $data = json_decode($jsonString, true);
    
        $listView = "<ul class='eq'>";
    
        // Iterate over the associative array
        foreach ($data as $key => $value) {
            // Check if the value is an array
            $isArray = is_array($value);
            // If the value is an array
            if ($isArray) {
                // Initialize an empty string for the array items
                $arrayItems = "";
                foreach ($value as $subKey => $subitem) {
                
                    $arrayItems .= "<li class='subkey'><div style='display: flex;'>
                                        <img id='img-$subKey'style='margin-left:50px; height:20px;'src='/oui/img/clock.png'>
                                            <div style='margin-left:10px; width: -webkit-fill-available;' onclick=\"openEQ('$eq','$subKey', this)\">
                                                <span>$subKey</span>
                                        </div>
                                    </li>";
                }
                $value = "<ul class='nested'>$arrayItems</ul>";
                // Add the caret class if the value is an array
                $keyElement = "<img id='img-$key'style='position:relative; top:5px; height:20px;'src='/oui/img/clock.png'></img> 
                                    <span class='caret'>
                                        <a onclick=\" openEQ('$eq','$key', this)\">$key</a>
                                    </span>";
            } 
            
            else if($value !== ""){
                //if has 1 value only
                $value = "<ul class='nested'>
                            <li>
                            <span style='margin-left:30px; display:list-item;'>
                                <span onclick=\"openEQ('$eq','$value', this)\">$value</span>
                            </span>
                            </li>
                           </ul>";
                $keyElement = "<span class='caret'><a onclick=\"openEQ('$eq','$key', this)\">$key</a></span>";
            }


            else {
                // If value not an array
                include('../include/img.php');
                $keyElement = "<div style='display: flex;'>
                                <img id='img-$key'style='height:20px;'src='/oui/img/clock.png'>
                                    <div style='margin-left:20px; width: -webkit-fill-available;' onclick=\"openEQ('$eq','$key', this)\">
                                        <span>$key</span>
                                </div>";
            }
            // Add the key-value pair to the list view
            $listView .= "<li>$keyElement $value</li>";
        }
    
        // Close the list view
        $listView .= "</ul>";
    
        // Return the list view string
        return $listView;
    }
    
    // JavaScript function to set session variable
    
    public static function displayEquipmentInfo($section,$jsonString){
        global $path;

        $display="<div id='$section-div' style='display:block;'> Select Equipment to begin with.</div>";
        $data = json_decode($jsonString, true);
        // Iterate over the associative array
        foreach ($data as $key => $value) {
            $isArray = is_array($value);
            if ($isArray) {
                echo "<div id='$section-$key-div' style='display:none;'>Equipment ID: $key";
                include($path . "include/main_eq_key.php");
                echo "</div>"; // outer most div 

                foreach ($value as $item =>$subitem) {
                    echo "<div id='$section-$item-div' style='display:none;'>Equipment ID: $item";
                    include($path . "include/main_eq_item.php");
                    echo "</div>"; // outer most div 
                }
        }

        else if($value !== ""){
            echo "<div id='$section-$key-div' style='display:none;'>Equipment ID: $key";
            include($path . "include/main_eq_key.php");
            echo "</div>"; // outer most div 

            echo "<div id='$section-$value-div' style='display:none;'>Equipment ID: $value";
            include($path . "include/main_eq_value.php");
            echo "</div>"; // outer most div 
        }

        else{ //only equipment no array
            echo "<div id='$section-$key-div' style='display:none;'>Equipment ID = <a style='font-size:30px; color:blue;'>$key </a>";
            include($path . "include/main_eq_key.php");
            echo "</div>"; // outer most div 
        }
    }
    //Log in button
    include("../include/LogIn.php");

    return $display;
    }
}

$response_section = makeCurlRequest("RequestShopFloorArea","OUI");
$response_section = str_replace(' ', '', $response_section);
$array=json_decode($response_section, true);
foreach ($array as $arrays) {
    $$arrays = new Section($arrays);
}
?>
<script>


function setSession(eq, value) {
    console.log("abc");
    // Send an AJAX request or redirect to a PHP script to set the session variable
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../set_session.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            // Session variable set successfully
            console.log('Session variable set successfully');
        } else {
            // Error setting session variable
            console.error('Error setting session variable');
        }
    };
    xhr.send('eq=' + encodeURIComponent(eq) + '&value=' + encodeURIComponent(value));
}



</script>
