<?php
include 'top.php';
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// We print out the post array so that we can see our form is working.
// if ($debug){  // later you can uncomment the if statement
// }
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.

$thisURL = $domain . $phpSelf;


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form

$firstName = "";
$lastaName = "";
$phoneNumber = "";
$email = "youremail@uvm.edu";
$gender = "Male";
$google = true;
$yourClassmates = false;
$twitter = false;
$other = false;
$webPages = "XiAn";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$firstNameERROR = false;
$lastNameERROR = false;
$phoneNumberERROR = false;
$emailERROR = false;
$genderERROR = false;
$activityERROR = false;
$totalChecked = 0;
$mountainERROR= false;
$webPagesError = false;
////%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

$dataRecord = array();
// array used to hold form values that will be written to a CSV file

$mailed = false;
// have we mailed the information to the user?
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a Security
    // 
    if (!securityCheck($thisURL)) {
        $msg = "<p>Sorry you cannot access this page.";
        $msg .= "Security breach detected and reported</p>";
        die($msg);
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.
    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;

    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastName;

    $phoneNumber = htmlentities($_POST["txtPhoneNumber"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $phoneNumber;

    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;

    $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $gender;

    if (isset($_POST["chkGoogle"])) {
        $google = true;
        $totalChecked++;
    } else {
        $google= false;
    }
    $dataRecord[] = $google;

    if (isset($_POST["chkYourClassmates"])) {
        $yourClassmates = true;
        $totalChecked++;
    } else {
        $yourClassmates = false;
    }
    $dataRecord[] = $yourClassmates;

    if (isset($_POST["chkTwitter"])) {
        $twitter = true;
        $totalChecked++;
    } else {
        $twitter = false;
    }
    $dataRecord[] = $twitter;

    if (isset($_POST["chkOther"])) {
        $other = true;
        $totalChecked++;
    } else {
        $other = false;
    }
    $dataRecord[] = $other;

    if ($totalChecked < 1) {
        $errorMsg[] = "Please choose at least one way";
        $activityERROR = true;
    }
    $webPages = htmlentities($_POST["lstWebPage"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $webPages;
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.

      if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have extra character";
        $firstNameERROR = true;
    }

    if ($lastName == "") {
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = "Your last name appears to have extra character";
        $lastNameERROR = true;
    }
    if ($phoneNumber == "") {
        $errorMsg[] = "Please enter your phone number";
        $phoneNumberERROR = true;
    } elseif (!verifyPhone($phoneNumber)) {
        $errorMsg[] = "Your photo number appears to have extra character";
        $phoneNumberERROR = true;
    }

    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = " Your email address appears to be incorrect.";
        $emailERROR = true;
    }

    if ($gender != "Male" AND $gender != "Female" AND $gender != "other") {
        $errorMsg[] = "Please choose a gender";
        $genderERROR = true;
    }
    if ($webPages == "") {
        $errorMsg[] = "Please choose a place";
        $webPagesError = true;
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //    
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";


        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //
        // This block saves the data to a CSV file.

        $fileExt = ".csv";
        $myFileName = "data/registration";
        $filename = $myFileName . $fileExt;

        if ($debug) {
            print "\n\n<p>filename is " . $filename;
        }

        // now we just open the file for append
        $file = fopen($filename, 'a');

        // write the forms informations
        fputcsv($file, $dataRecord);

        // close the file
        fclose($file);


        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).

        $message = '<h2>Your information.</h2>';

        foreach ($_POST as $htmlName => $value) {
            $message .= "<p>";

            //breaks up the form name into words. for example
            //txtFirstName becomes First Name
            $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));

            foreach ($camelCase as $oneWord) {
                $message .= $oneWord . " ";
            }

            $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }


        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        // SECTION: 2g Mail to user
        //    
        // Process for mailing a message which contains the forms data         
        // the message was built in section 2f.    

        $to = $email;
        $cc = "";
        $bcc = "";

        $from = "WRONG site <customer.service@yoursite.com";

//subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "Research Study: " . $todaysDate;

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    }
}


//#############################################################################
//
// SECTION 3 Display Form
//
?>

<article id="main">

    <?php
//####################################
//
// SECTION 3a. 
// 
// If its the first time coming to the form or there are errors we are going
// to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) {// closing of if marked with end body submit
        print "<h2>Thank you for providing your information.</h2>";

        print"<p>For your records a copy of this data has";

        if (!$mailed) {
            print "not";
        }
        print"been sent:</p>";
        print "<p> To:" . $email . "</p>";

        print $message;
    } else {

        print '<h2>Questionnaire Survey</h2>';
        print '<p class="form-heading">Your information will greatly help us with our research.</p>';

        //####################################
        //
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form

        if ($errorMsg) {
            print'<div id="errors">' . "\n";
            print"<h2>Your form has the following mistakes that need to be fixed</h2>\n";
            print"<ol>\n";

            foreach ($errorMsg as $err) {
                print"<li>" . $err . "</li>\n";
            }

            print "</ol>\n";
            print "</div>\n";
        }

        //####################################
        //
        // SECTION 3c html Form
        //
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:
          value="<?php print $email; ?>
          this makes the form sticky by displaying either the initial default value (line ??)
          or the value they typed in (line ??)
          NOTE this line:
          <?php if($emailERROR) print 'class="mistake"'; ?>
          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.
         */
        ?>

        <form action="<?php print $phpSelf; ?>"
              id="frmRegister"
              method="post">

            <fieldset class="contact">
                <legend>Contact Information</legend>
                <p>
                    <label class="required text-field" for="txtFirstName">First Name</label>
                    <input autofocus
                    <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                           id="txtFirstName"
                           maxlength="45"
                           name="txtFirstName"
                           onfocus="this.select()"
                           placeholder="Enter your first name"
                           tabindex="100"
                           type="text"
                           value="<?php print $firstName; ?>"
                           >
                </p>
                <p>
                    <label class="required text-field" for="txtLastName">Last Name</label>
                    <input 
                    <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                        id="txtLastName"
                        maxlength="45"
                        name="txtLastName"
                        onfocus="this.select()"
                        placeholder="Enter your last name"
                        tabindex="100"
                        type="text"
                        value="<?php print $lastName; ?>"
                        >
                </p>
                <p>
                    <label class="required text-field" for="txtPhoneNumber">Phone Number</label>
                    <input 
                    <?php if ($phoneNumberERROR) print 'class="mistake"'; ?>
                        id="txtPhoneNumber"
                        maxlength="45"
                        name="txtPhoneNumber"
                        onfocus="this.select()"
                        placeholder="Enter your phone number"
                        tabindex="100"
                        type="text"
                        value="<?php print $phoneNumber; ?>"
                        >
                </p>
                <p>
                    <label class="required text-field" for="txtEmail">Email</label>
                    <input
                    <?php if ($emailERROR) print 'class="mistake"'; ?>
                        id="txtEmail"
                        maxlength="45"
                        name="txtEmail"
                        onfocus="this.select()"
                        placeholder="Enter a valid email address"
                        tabindex="120"
                        type="text"
                        value="<?php print $email; ?>"
                        >
                </p>
            </fieldset>
            <fieldset class="radio <?php if ($genderERROR) print ' mistake'; ?>">
                <legend>Gender</legend>
                <p>
                    <label class="radio-field">
                        <input type="radio" 
                               id="radGenderMale" 
                               name="radGender" 
                               value="Male" 
                               tabindex="572"
                               <?php if ($gender == "Male") echo ' checked="checked" '; ?>>
                        Male</label>
                </p>

                <p>    
                    <label class="radio-field">
                        <input type="radio" 
                               id="radGenderFemale" 
                               name="radGender" 
                               value="Female" 
                               tabindex="582"
                               <?php if ($gender == "Female") echo ' checked="checked" '; ?>>
                        Female</label>
                </p>
                <p>    
                    <label class="radio-field">
                        <input type="radio" 
                               id="radGenderOther" 
                               name="radGender" 
                               value="Other" 
                               tabindex="582"
                               <?php if ($gender == "Other") echo ' checked="checked" '; ?>>
                        other</label>
                </p>
            </fieldset>
            <fieldset class="checkbox <?php if ($activityERROR) print ' mistake'; ?>">
                <legend>How do you know us?</legend>

                <p>
                    <label class="check-field">
                        <input <?php if ($google) print " checked "; ?>
                            id="chkGoogle"
                            name="chkGoogle"
                            tabindex="420"
                            type="checkbox"
                            value="Google"> Google</label>
                </p>
                <p>
                    <label class="check-field">
                        <input <?php if ($yourClassmates) print " checked "; ?>
                            id="chkYourClassmates"
                            name="chkYourClassmates"
                            tabindex="420"
                            type="checkbox"
                            value="YourClassmates"> Your Classmates</label>
                </p>
                <p>
                    <label class="check-field">
                        <input <?php if ($twitter) print " checked "; ?>
                            id="chkTwitter"
                            name="chkTwitter"
                            tabindex="420"
                            type="checkbox"
                            value="Twitter"> Twitter </label>
                </p>
                <p>
                    <label class="check-field">
                        <input <?php if ($other) print " checked "; ?>
                            id="chkOther"
                            name="chkOther"
                            tabindex="420"
                            type="checkbox"
                            value="Other"> Other</label>
            </fieldset>
            <fieldset  class="listbox <?php if ($mountainERROR) print ' mistake'; ?>">

                <legend>Where do you want to go most?</legend>
                <p>
                    <select id="lstWebPage" 
                            name="lstWebPage" 
                            tabindex="520" >
                        <option <?php if ($webPages == "XiAn") print " selected "; ?>
                            value="XiAn">XiAn</option>
                        <option <?php if ($webPages == "SuZhou") print " selected "; ?>
                            value="XiAn">SuZhou</option>
                        <option <?php if ($webPages == "ChenDu") print " selected "; ?>
                            value="ChenDu">ChenDu</option>
                        <option <?php if ($webPages == "HuangShan") print " selected "; ?>
                            value="HuangShan">HuangShan</option>
                        <option <?php if ($webPages == "LiJiang") print " selected "; ?>
                            value="LiJiang">LiJiang</option>
                    </select>
                </p>
            </fieldset>
            <fieldset class="buttons">
                <legend></legend>
                <input class="button" id="btnSubmit" name="btnSubmit" tabindex="900" type="submit" value="Register" >
            </fieldset><!--ends buttons -->
        </form>
        <?php
    }//end body submit
    ?>


</article>

<?php include 'footer.php'; ?>

</body>
</html>