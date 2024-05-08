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
                    $arrayItems .= "<li class=><span style='margin-left:30px; display:list-item;'><span onclick=\"openEQ('$eq','$subKey', this)\">$subKey</span></span></li>";
                }
                $value = "<ul class='nested'>$arrayItems</ul>";
                // Add the caret class if the value is an array
                $keyElement = "<span class='caret'><a onclick=\" openEQ('$eq','$key', this)\">$key</a></span>";
            } else if($value !== ""){
                //if has 1 value only
                $value = "<ul class='nested'><li><span style='margin-left:30px; display:list-item;'><span onclick=\"openEQ('$eq','$value', this)\">$value</span></span></li></ul>";
                $keyElement = "<span class='caret'><a onclick=\"openEQ('$eq','$key', this)\">$key</a></span>";
            }
            else {
                // If value not an array
                $keyElement = "<img style='height:20px;'src='/oui/img/clock.png'><span><a style='margin-left:20px;' onclick=\"openEQ('$eq','$key', this)\">$key</a></span>";
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
                include($path . "include/main_eq.php");
                echo "</div>"; // outer most div 

                foreach ($value as $item =>$subitem) {
                    echo "<div id='$section-$item-div' style='display:none;'>Equipment ID: $item";
                    include($path . "include/main_eq.php");
                    echo "</div>"; // outer most div 
                }
        }

        else if($value !== ""){
            echo "<div id='$section-$key-div' style='display:none;'>Equipment ID: $key";
            include($path . "include/main_eq.php");
            echo "</div>"; // outer most div 

            echo "<div id='$section-$value-div' style='display:none;'>Equipment ID: $value";
            include($path . "include/main_eq.php");
            echo "</div>"; // outer most div 
        }

        else{ //only equipment no array
            echo "<div id='$section-$key-div' style='display:none;'>Equipment ID = $key";
            include($path . "include/main_eq.php");
            echo "</div>"; // outer most div 
        }
    }
    //Log in button
    include("../include/LogIn.php");

    return $display;
    }
}

//Get section names
// $ini_contents = file("D:\OUI stuff\Simulation\CCM\CCM.ini");
// $sections = [];
// $current_section = '';

// // Iterate over each line in the INI file
// foreach ($ini_contents as $line_number => $line) {
//     // Trim leading and trailing whitespace
//     $line = trim($line);
    
//     // Skip empty lines
//     if (empty($line)) {
//         continue;
//     }
    
//     // If the line contains a section header
//     if ($line[0] === '[' && substr($line, -1) === ']') {
//         // Get the section name
//         $current_section = trim($line, '[]');
//         // Create a new array for the section
//         $sections[$current_section] = [];
//     } else {
//         // Split the line into key and value (if applicable)
//         $parts = explode('=', $line, 2);
//         $key = trim($parts[0]);
//         $value = isset($parts[1]) ? trim($parts[1]) : ''; // If no value, use empty string
        
//         // Check if the value contains multiple items separated by commas
//         if (strpos($value, ',') !== false) {
//             // If so, split the value and format it accordingly
//             $items = explode(',', $value);
//             foreach ($items as $item) {
//                 $sections[$current_section][$key][] = trim($item);
//             }
//         } else {
//             // If not, add the key-value pair to the current section
//             $sections[$current_section][$key] = $value;
//         }
        
//         // Check if the next line contains a section header
//         if (isset($ini_contents[$line_number + 1]) && $ini_contents[$line_number + 1][0] === '[' && substr($ini_contents[$line_number + 1], -1) === ']') {
//             // If so, move to the next section
//             $current_section = '';
//         }
//     }
// }

// function customSort($a, $b) {
//     // Convert both keys to lowercase
//     $aLower = strtolower($a);
//     $bLower = strtolower($b);

//     // Check if both keys are numeric
//     $aIsNumeric = is_numeric($a);
//     $bIsNumeric = is_numeric($b);

//     // If both are numeric, compare them numerically
//     if ($aIsNumeric && $bIsNumeric) {
//         return $a - $b;
//     }
//     // If one is numeric and the other is not, the numeric one comes first
//     elseif ($aIsNumeric) {
//         return -1;
//     } elseif ($bIsNumeric) {
//         return 1;
//     }

//     // If both are not numeric, compare them alphabetically
//     return strcasecmp($aLower, $bLower);
// }
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
