<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
include_once "classes/user.php";
$ul   	= new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Attempt to add user
    $addUser = $ul->userAdd($_POST);
}
?>

<div class="colorlib-shop">
<div class="container">
<div class="col-md-7">
<?php
    if (isset($addUser)) {
    echo "<span class='error'>". $addUser. "</span>";
}
?>
<style>.error{color:red;font-weight:bold;}</style>
<form method="post" class="colorlib-form">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                    <div class="col-md-6">
                        <label for="fname">First Name</label>
                        <input type="text" id="fname" class="form-control" name="userFirstName" placeholder="Your firstname">
                    </div>
                    <div class="col-md-6">
                        <label for="lname">Last Name</label>
                        <input type="text" id="lname" class="form-control" name="userLastName" placeholder="Your lastname">
                    </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="lname">Full Name</label>
                <input type="text" id="lname" class="form-control" name="userFullName" placeholder="Your Fullname">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="companyname">Company Name</label>
                <input type="text" id="companyname" class="form-control" name="userCompanyName" placeholder="Company Name">
            </div>
            <div class="form-group">
                    <label for="country">Select Country</label>
                    <div class="form-field">
                        <i class="icon icon-arrow-down3"></i>
                        <select name="userCountry" id="people" class="form-control">
                            <option value="#">Select country</option>
                            <option value="#">Alaska</option>
                            <option value="#">China</option>
                            <option value="#">Japan</option>
                            <option value="#">Korea</option>
                            <option value="#">Philippines</option>
                        </select>
                    </div>
            </div>
        </div>
        <div class="col-md-12">
                <div class="form-group">
                    <label for="fname">Address</label>
                    <input type="text" id="address" class="form-control" name="userAddress"placeholder="Enter Your Address">
                </div>

        </div>
        <div class="col-md-12">
                <div class="form-group">
                    <label for="">Town/City</label>
                    <input type="text" id="towncity" class="form-control" name="userCity" placeholder="Town or City">
                </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                    <div class="col-md-6">
                        <label for="stateprovince">State/Province</label>
                        <input type="text" id="fname" class="form-control" name="userState" placeholder="State Province">
                    </div>
                    <div class="col-md-6">
                        <label for="zip">Zip/Postal Code</label>
                        <input type="text" id="zippostalcode" class="form-control" name="userZipCode" placeholder="Zip / Postal">
                    </div>
            </div>
            <div class="form-group">

                <div class="col-md-6">
                    <label for="Phone">Phone Number</label>
                    <input type="text" id="zippostalcode" class="form-control" name="userPhoneNumber" placeholder="">
                </div>
            </div>

        </div>
        <div class="form-group">
            <div class="col-md-12">
            <div class="form-group">
                <label for="email">E-mail Address</label>
                <input type="text" id="email" class="form-control" name="userEmail" placeholder="Enter Your Email" value="<?php echo isset($login['email']) ? $login['email'] : ''; ?>">
            </div>

            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" name="UserPassword" placeholder="Enter Your Password">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="radio">
                    <label><input type="radio" name="optradio">Create an Account?</label>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="submit">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>