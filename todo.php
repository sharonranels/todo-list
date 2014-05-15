<?php

// Create array to hold list of todo items
$items = array();

// List array items formatted for CLI
    // Return string of list items separated by newlines.
    // Should be listed [KEY] Value like this:
    // [1] TODO item 1
    // [2] TODO item 2 - blah
    // DO NOT USE ECHO, USE RETURN
function list_items($list) {
    $todos = "";
    foreach ($list as $key => $item) {
        $temp_key = $key + 1;
        // Display each item and a newline
        $todos .= "[{$temp_key}] {$item}\n";
    }
    return $todos;
    

}


// Get STDIN, strip whitespace and newlines, 
// and convert to uppercase if $upper is true
// DEFAULT = ($upper = FALSE) in THIS CASE
function get_input($upper = FALSE) {
    $input = trim(fgets(STDIN));
    
    if ($upper == TRUE) {
       $input = strtoupper($input);
    }

    return $input;
}

// The loop!
do {
    // Echo the list produced by the function
    echo list_items($items);
    // Show the menu options
    echo '(N)ew item, (O)pen existing list, (R)emove item, (S)ort items, (Q)uit, Sa(V)e : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = get_input(true);

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        
        echo 'Enter item: ';
        // Add entry to list array
        $new_items = get_input();

        echo 'Do you want to add this to the (B)eginning or (E)nd of the list? ';
        $input = get_input(true);
        if ($input == 'B') {
            array_unshift($items, $new_items);
        } else {
            array_push($items, $new_items);
        }
    
    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $rkey = get_input();
        $rkey = $rkey - 1;
        // Remove from array
        unset($items[$rkey]);
        $items = array_values($items);
    
    // ADD SORT OPTION

    } elseif ($input == 'O') {
        $filename = "data/todo_list.txt";
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        $contents_array = explode("\n", $contents);
        fclose($handle);
        foreach ($contents_array as $new_info) {
           array_push($items, $new_info);
        }
    

    } elseif ($input == 'V') {
        echo 'What is the name of the file to which you would like to save? ';
        $input = get_input(true);
        $handle = fopen($filename, "w+");
        if (file_exists($input)) {
            echo 'This file already exists - do you want to overwrite it? ';    
        }
        
        foreach ($items as $task) {
            if(fwrite($handle, PHP_EOL . $task)) {
            
            } else {
                file_put_contents($filename, $input);
            }
        }
        fclose($handle);

    } elseif ($input == 'S') {
        echo 'Do you want to sort (A to Z) or (Z to A)? (enter A or Z) ';
        $input = get_input(true);
        if ($input == 'A') {
            sort($items);
        } else {
            rsort($items);
        }
            
    } elseif ($input == 'F') {
        array_pop($items);
    
    } elseif ($input == 'L') {
        array_shift($items);
    }    


// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);
?>