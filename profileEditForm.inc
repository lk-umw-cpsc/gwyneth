<?php
    require_once('domain/Person.php');
    require_once('database/dbPersons.php');
    require_once('include/output.php');
    $isAdmin = false;
    if ($_SESSION['access_level'] >= 2 && isset($_GET['id'])) {
        $id = $_GET['id'];
	$isAdmin = true;
        // Check to see if user is a lower-level manager here
    } else {
        $id = $_SESSION['_id'];
    }

    $person = retrieve_person($id);
?>
<h1>Manage Profile</h1>
<main class="signup-form">
    
    <?php if ($isAdmin) : ?>
    	<form class = "modify-access" method = "post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="modify_access" value="Modify User Access">
    	</form>
    <?php endif ?>
    <?php if ($id == 'vmsroot') : ?>
        <p>This user account cannot be modified</p></main></body>
        <?php die() ?>
    <?php endif ?>
    <form class="signup-form" method="post">
        <br>
	    <p>An asterisk (<label><em>*</em></label>) indicates a required field.</p>
        <fieldset>
            <legend>Personal Information</legend>
            <p>The following information helps us identify you within our system.</p>
            <label for="first-name"><em>* </em>First Name</label>
            <input type="text" id="first-name" name="first-name" value="<?php echo hsc($person->get_first_name()); ?>" required placeholder="Enter your first name">

            <label for="last-name"><em>* </em>Last Name</label>
            <input type="text" id="last-name" name="last-name" value="<?php echo hsc($person->get_last_name()); ?>" required placeholder="Enter your last name">

            <label for="birthdate"><em>* </em>Date of Birth</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo hsc($person->get_birthday()); ?>" required placeholder="Choose your birthday" max="<?php echo date('Y-m-d'); ?>">


            <label for="address"><em>* </em>Street Address</label>
            <input type="text" id="address" name="address" value="<?php echo hsc($person->get_address()); ?>" required placeholder="Enter your street address">

            <label for="city"><em>* </em>City</label>
            <input type="text" id="city" name="city" value="<?php echo hsc($person->get_city()); ?>" required placeholder="Enter your city">

            <label for="state"><em>* </em>State</label>
            <select id="state" name="state" required>
                <?php
                    $state = $person->get_state();
                    $states = array(
                        'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'District Of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
                    );
                    $abbrevs = array(
                        'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY'
                    );
                    $length = count($states);
                    for ($i = 0; $i < $length; $i++) {
                        if ($abbrevs[$i] == $state) {
                            echo '<option value="' . $abbrevs[$i] . '" selected>' . $states[$i] . '</option>';
                        } else {
                            echo '<option value="' . $abbrevs[$i] . '">' . $states[$i] . '</option>';
                        }
                    }
                ?>
            </select>

            <label for="zip"><em>* </em>Zip Code</label>
            <input type="text" id="zip" name="zip" value="<?php echo hsc($person->get_zip()); ?>" pattern="[0-9]{5}" title="5-digit zip code" required placeholder="Enter your 5-digit zip code">
        </fieldset>
        <fieldset>
            <legend>Contact Information</legend>
            <p>The following information helps us determine the best way to contact you regarding event coordination.</p>
            <label for="email"><em>* </em>E-mail</label>
            <p>Updating your e-mail address does not change your login username.</p>
            <input type="email" id="email" name="email" value="<?php echo hsc($person->get_email()); ?>" required placeholder="Enter your e-mail address">

            <label for="phone"><em>* </em>Phone Number</label>
            <input type="tel" id="phone" name="phone" value="<?php echo formatPhoneNumber($person->get_phone1()); ?>" pattern="\([0-9]{3}\) [0-9]{3}-[0-9]{4}" required placeholder="Ex. (555) 555-5555">

            <label><em>* </em>Phone Type</label>
            <div class="radio-group">
                <?php $type = $person->get_phone1type(); ?>
                <input type="radio" id="phone-type-cellphone" name="phone-type" value="cellphone" <?php if ($type == 'cellphone') echo 'checked'; ?> required><label for="phone-type-cellphone">Cell</label>
                <input type="radio" id="phone-type-home" name="phone-type" value="home" <?php if ($type == 'home') echo 'checked'; ?> required><label for="phone-type-home">Home</label>
                <input type="radio" id="phone-type-work" name="phone-type" value="work" <?php if ($type == 'work') echo 'checked'; ?> required><label for="phone-type-work">Work</label>
            </div>

            <label for="contact-when" required><em>* </em>Best Time to Reach You</label>
            <input type="text" id="contact-when" name="contact-when" value="<?php echo hsc($person->get_contact_time()); ?>" required placeholder="Ex. Evenings, Days">

            <label><em>* </em>Preferred Contact Method</label>
            <div class="radio-group">
                <?php $method = $person->get_cMethod(); ?>
                <input type="radio" id="method-phone" name="contact-method" value="phone" <?php if ($method == 'phone') echo 'checked'; ?> required><label for="method-phone">Phone call</label>
                <input type="radio" id="method-text" name="contact-method" value="text" <?php if ($method == 'text') echo 'checked'; ?> required><label for="method-text">Text</label>
                <input type="radio" id="method-email" name="contact-method" value="email" <?php if ($method == 'email') echo 'checked'; ?> required><label for="method-email">E-mail</label>
            </div>
        </fieldset>
        <fieldset>
            <legend>Emergency Contact</legend>
            <p>Please provide us with someone to contact on your behalf in case of an emergency.</p>
            <label for="econtact-name" required><em>* </em>Contact Name</label>
            <input type="text" id="econtact-name" name="econtact-name" value="<?php echo hsc($person->get_contact_name()); ?>" required placeholder="Enter emergency contact name">

            <label for="econtact-phone"><em>* </em>Contact Phone Number</label>
            <input type="tel" id="econtact-phone" name="econtact-phone" value="<?php echo formatPhoneNumber($person->get_contact_num()); ?>" pattern="\([0-9]{3}\) [0-9]{3}-[0-9]{4}" required placeholder="Enter emergency contact phone number. Ex. (555) 555-5555">

            <label for="econtact-name"><em>* </em>Contact Relation to You</label>
            <input type="text" id="econtact-relation" name="econtact-relation" value="<?php echo hsc($person->get_relation()); ?>" required placeholder="Ex. Spouse, Mother, Father, Sister, Brother, Friend">
        </fieldset>
        <fieldset>
            <legend>Volunteer Information</legend>
            <p>The following information helps us determine your availability and skillset.</p>
            
            <label><em>* </em>Availability</label>
            <p>Enter the days and times you will be available to volunteer each week, starting from the date above.</p>
            <div class="availability-container">
                <?php
                    $start = $person->get_sunday_availability_start();    
                    $end = $person->get_sunday_availability_end();    
                    $day = $start && $end;
                ?>
                <div class="availability-day">
                    <p class="availability-day-header">
                        <input id="available-sundays" name="available-sundays" type="checkbox" <?php if ($day) echo 'checked'; ?>>
                        <label for="available-sundays">Sundays</label>
                    </p>
                    <p><em class="hidden">* </em>From</p>
                    <input type="text" id="sundays-start" name="sundays-start" value="<?php echo time24hTo12h($start); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 8:00AM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p><em class="hidden">* </em>to</p>
                    <input type="text" id="sundays-end" name="sundays-end" value="<?php echo time24hTo12h($end); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 4:00PM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p id="sundays-range-error" class="hidden error">Start time must come before end time.</p>
                </div>
                <?php
                    $start = $person->get_monday_availability_start();    
                    $end = $person->get_monday_availability_end();    
                    $day = $start && $end;
                ?>
                <div class="availability-day">
                    <p class="availability-day-header">
                        <input id="available-mondays" name="available-mondays" type="checkbox" <?php if ($day) echo 'checked'; ?>>
                        <label for="available-mondays">Mondays</label>
                    </p>
                    <p><em class="hidden">* </em>From</p>
                    <input type="text" id="mondays-start" name="mondays-start" value="<?php echo time24hTo12h($start); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 8:00AM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p><em class="hidden">* </em>to</p>
                    <input type="text" id="mondays-end" name="mondays-end" value="<?php echo time24hTo12h($end); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 4:00PM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p id="mondays-range-error" class="hidden error">Start time must come before end time.</p>
                </div>
                <?php
                    $start = $person->get_tuesday_availability_start();    
                    $end = $person->get_tuesday_availability_end();    
                    $day = $start && $end;
                ?>
                <div class="availability-day">
                    <p class="availability-day-header">
                        <input id="available-tuesdays" name="available-tuesdays" type="checkbox" <?php if ($day) echo 'checked'; ?>>
                        <label for="available-tuesdays">Tuesdays</label>
                    </p>
                    <p><em class="hidden">* </em>From</p>
                    <input type="text" id="tuesdays-start" name="tuesdays-start" value="<?php echo time24hTo12h($start); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 8:00AM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p><em class="hidden">* </em>to</p>
                    <input type="text" id="tuesdays-end" name="tuesdays-end" value="<?php echo time24hTo12h($end); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 4:00PM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p id="tuesdays-range-error" class="hidden error">Start time must come before end time.</p>
                </div>
                <?php
                    $start = $person->get_wednesday_availability_start();    
                    $end = $person->get_wednesday_availability_end();    
                    $day = $start && $end;
                ?>
                <div class="availability-day">
                    <p class="availability-day-header">
                        <input id="available-wednesdays" name="available-wednesdays" type="checkbox" <?php if ($day) echo 'checked'; ?>>
                        <label for="available-wednesdays">Wednesdays</label>
                    </p>
                    <p><em class="hidden">* </em>From</p>
                    <input type="text" id="wednesdays-start" name="wednesdays-start" value="<?php echo time24hTo12h($start); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 8:00AM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p><em class="hidden">* </em>to</p>
                    <input type="text" id="wednesdays-end" name="wednesdays-end" value="<?php echo time24hTo12h($end); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 4:00PM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p id="wednesdays-range-error" class="hidden error">Start time must come before end time.</p>
                </div>
                <?php
                    $start = $person->get_thursday_availability_start();    
                    $end = $person->get_thursday_availability_end();    
                    $day = $start && $end;
                ?>
                <div class="availability-day">
                    <p class="availability-day-header">
                        <input id="available-thursdays" name="available-thursdays" type="checkbox" <?php if ($day) echo 'checked'; ?>>
                        <label for="available-thursdays">Thursdays</label>
                    </p>
                    <p><em class="hidden">* </em>From</p>
                    <input type="text" id="thursdays-start" name="thursdays-start" value="<?php echo time24hTo12h($start); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 8:00AM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p><em class="hidden">* </em>to</p>
                    <input type="text" id="thursdays-end" name="thursdays-end" value="<?php echo time24hTo12h($end); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 4:00PM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p id="thursdays-range-error" class="hidden error">Start time must come before end time.</p>
                </div>
                <?php
                    $start = $person->get_friday_availability_start();    
                    $end = $person->get_friday_availability_end();    
                    $day = $start && $end;
                ?>
                <div class="availability-day">
                    <p class="availability-day-header">
                        <input id="available-fridays" name="available-fridays" type="checkbox" <?php if ($day) echo 'checked'; ?>>
                        <label for="available-fridays">Fridays</label>
                    </p>
                    <p><em class="hidden">* </em>From</p>
                    <input type="text" id="fridays-start" name="fridays-start" value="<?php echo time24hTo12h($start); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 8:00AM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p><em class="hidden">* </em>to</p>
                    <input type="text" id="fridays-end" name="fridays-end" value="<?php echo time24hTo12h($end); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 4:00PM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p id="fridays-range-error" class="hidden error">Start time must come before end time.</p>
                </div>
                <?php
                    $start = $person->get_saturday_availability_start();    
                    $end = $person->get_saturday_availability_end();    
                    $day = $start && $end;
                ?>
                <div class="availability-day">
                    <p class="availability-day-header">
                        <input id="available-saturdays" name="available-saturdays" type="checkbox" <?php if ($day) echo 'checked'; ?>>
                        <label for="available-saturdays">Saturdays</label>
                    </p>
                    <p><em class="hidden">* </em>From</p>
                    <input type="text" id="saturdays-start" name="saturdays-start" value="<?php echo time24hTo12h($start); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 8:00AM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p><em class="hidden">* </em>to</p>
                    <input type="text" id="saturdays-end" name="saturdays-end" value="<?php echo time24hTo12h($end); ?>" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" placeholder="Ex. 4:00PM" <?php if (!$day) echo 'disabled'; else echo 'required'; ?>>
                    <p id="saturdays-range-error" class="hidden error">Start time must come before end time.</p>
                </div>
            </div>

            <label for="skills">Skills</label>
            <textarea id="skills" name="skills" placeholder="Please let us know about any special skills you may have, including proficiencies in non-English languages."><?php echo $person->get_specialties(); ?></textarea>

            <label>Additional Information</label>
            <div class="checkbox-grouping">
                <div class="checkbox-pair">
                    <input id="has-computer" name="has-computer" type="checkbox" <?php if ($person->get_computer()) echo 'checked'; ?>>
                    <label for="has-computer">I own a computer</label>
                </div>
                <div class="checkbox-pair">
                    <input id="has-camera" name="has-camera" type="checkbox" <?php if ($person->get_camera()) echo 'checked'; ?>>
                    <label for="has-camera">I own a camera</label>
                </div>
                <div class="checkbox-pair">
                    <input id="has-transportation" name="has-transportation" type="checkbox" <?php if ($person->get_transportation()) echo 'checked'; ?>>
                    <label for="has-transportation">I have access to reliable transportation</label>
                </div>
            </div>

            <label for="shirt-size">T-shirt Size</label>
            <select id="shirt-size" name="shirt-size" required>
                <?php $size = $person->get_shirt_size(); ?>
                <option value="S" <?php if ($size == 'S') echo 'selected'; ?>>Small</option>
                <option value="M" <?php if ($size == 'M') echo 'selected'; ?>>Medium</option>
                <option value="L" <?php if ($size == 'L') echo 'selected'; ?>>Large</option>
                <option value="XL" <?php if ($size == 'XL') echo 'selected'; ?>>Extra Large</option>
                <option value="XXL" <?php if ($size == 'XXL') echo 'selected'; ?>>2X Large</option>
            </select>
        </fieldset>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" name="profile-edit-form" value="Update Profile">
    </form>
</main>
