<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinigami Vault 
        <?php if(isset($_SESSION['customer_id'])) { ?>
             | <?php echo $_SESSION['customer_name']; ?>
        <?php }?>
    </title>

    <!-- stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="icon" href="assets/logo.png" />
</head>

<body>

    <!-- header -->
    <?php 
    include "connection.php"; 
    include "header.php"; ?>

    
<div class="profile-container">

    <?php
    $customer_id = $_SESSION['customer_id'];

    $customer_rs = Database::search("
        SELECT * FROM customer WHERE id = '$customer_id'
    ");

    $customer_data = $customer_rs->fetch_assoc();
    ?>
    <aside class="profile-lhs">
        <div style="display: flex; flex-direction: column; align-items: center; width: 100%; text-align: center;">
            <div class="avatar-circle">
                <img src="assets/logo.png" alt="Avatar" class="avatar-img">
            </div>

            <h5 class="profile-name"><?php echo $customer_data['fullname']; ?></h5>
            <h6 class="profile-email"><?php echo $customer_data['email']; ?></h6>

            <h6 class="profile-date">joined since <?php echo date('F, Y', strtotime($customer_data['joined_date'])); ?></h6>
            <br><br><br>
            <button class="saveChanges-btn ">change your password</button>
            <button class="saveChanges-btn mt-1">Your Orders</button>
        </div>
        
    </aside>

    
    <main class="profile-rhs">

        <div class="profile-details">
            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 1.5rem;">
                <h5 class="profile-headings">Profile Details</h5>
                <button class="saveChanges-btn">save profile details</button>
            </div>
            

            <div class="form-row">
                <!-- Full name -->
                <div class="field-wrap">
                    <input class="field-input" value="<?php echo $customer_data['fullname']; ?>" type="text" id="" placeholder=" " />
                    <label class="field-label" for="" >Fullname</label>
                </div>
                <!-- Email -->
                <div class="field-wrap">
                    <input class="field-input" value="<?php echo $customer_data['email']; ?>" type="text" id="" placeholder=" " readonly/>
                    <label class="field-label" for="">Email Address</label>
                </div>
                <!-- password -->
                <div class="field-wrap">
                    <input class="field-input" type="password" id="pf_password" placeholder=" " 
                        style="letter-spacing: 8px;" maxlength="8" value="<?php echo $customer_data['password']; ?>" readonly/>
                    <label class="field-label" for="pf_password">Password</label>
                    <button class="show-pw-btn" onclick="showPwProfile();">
                        <i id="pf_password_icon" class="bi bi-eye-slash"></i>
                    </button>
                </div>
                
            </div>

        </div>
        <br>
        <div class="profile-details">
            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 1.5rem;">
                <h5 class="profile-headings">Shipping Details</h5>
                <button class="saveChanges-btn">save shipping details</button>
            </div>

            <div class="form-row">
                <!-- line 2 -->
                <div class="field-wrap">
                    <input class="field-input" value="customer fullname" type="text" id="" placeholder=" " />
                    <label class="field-label" for="" >Line 01</label>
                </div>
                <!-- line 2 -->
                <div class="field-wrap">
                    <input class="field-input" value="customer fullname" type="text" id="" placeholder=" " />
                    <label class="field-label" for="" >Line 02</label>
                </div>

                <!-- city -->
                <div class="field-wrap field-select-wrap">
                    <select class="field-select" id="" >
                        <option value="" disabled selected hidden></option>
                        <option value="1">city</option>
                    </select>
                    <label class="field-label" for="">City</label>
                    <span class="chevron">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </span>
                </div>
                <!-- if user has city -->
                <!-- <div class="field-wrap">
                    <input class="field-input" value="customer fullname" type="text" id="" placeholder=" " />
                    <label class="field-label" for="" >City</label>
                </div> -->

                <!-- disctrict -->
                <div class="field-wrap field-select-wrap">
                    <select class="field-select" id="" >
                        <option value="" disabled selected hidden></option>
                        <option value="1">city</option>
                    </select>
                    <label class="field-label" for="">District</label>
                    <span class="chevron">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </span>
                </div>
                <!-- if user has disctrict -->
                <!-- <div class="field-wrap">
                    <input class="field-input" value="customer fullname" type="text" id="" placeholder=" " />
                    <label class="field-label" for="" >District</label>
                </div> -->

                <!-- provice -->
                <div class="field-wrap field-select-wrap">
                    <select class="field-select" id="" >
                        <option value="" disabled selected hidden></option>
                        <option value="1">city</option>
                    </select>
                    <label class="field-label" for="">Province</label>
                    <span class="chevron">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </span>
                </div>
                <!-- if user has province -->
                <!-- <div class="field-wrap">
                    <input class="field-input" value="customer fullname" type="text" id="" placeholder=" " />
                    <label class="field-label" for="" >Province</label>
                </div> -->

                <!-- postal code -->
                <div class="field-wrap">
                    <input class="field-input" value="customer fullname" type="text" id="" placeholder=" " />
                    <label class="field-label" for="" >Postal code</label>
                </div>

                <!-- contact -->
                <div class="field-wrap">
                    <input class="field-input" value="customer fullname" type="text" id="" placeholder=" " />
                    <label class="field-label" for="" >Contact 1</label>
                </div>

                <!-- contact -->
                <div class="field-wrap">
                    <input class="field-input" value="customer fullname" type="text" id="" placeholder=" " />
                    <label class="field-label" for="" >Contact 2</label>
                </div>
                
            </div>

        </div>
    </main>

</div>


    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script>
        function showPwProfile(){
            var pw = document.getElementById("pf_password");
            var pwicon = document.getElementById("pf_password_icon");

            if (pw.type == "password") {
                pw.type = "text";
                pwicon.className = "bi bi-eye";
            } else {
                pw.type = "password";
                pwicon.className = "bi bi-eye-slash";
            }
        }
    </script>
</body>

</html>

<style>
    .profile-container {
        display: flex;
        flex: 1;
        padding: 24px 24px 32px;
        gap: 20px;
    }
    .profile-lhs {
        width: 400px;
        min-width: 280px;
        background: var(--white);
        border: 1px solid #dcdcdc;
        border-radius: 14px;
        padding: 20px 0 24px;
        position: sticky;
        height: 85vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .avatar-circle {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: var(--hero-bg, #f0f0f0);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        overflow: hidden;
        border: 3px solid rgba(0,0,0,0.06);
    }
 
    .avatar-img {
        width: 95%;
        height: 95%;
        object-fit: contain;
        border-radius: 100px;
    }
    .profile-name {
        font-family: 'header';
        font-size: 1.4rem;
        color: var(--black);
        margin-bottom: 4px;
        letter-spacing: 0.05em;
        text-align: center;
    }
 
    .profile-email {
        font-size: 0.75rem;
        color: var(--dark-grey);
        margin-bottom: 5rem;
        letter-spacing: 1px;
        text-align: center;
    }
    .profile-date {
        font-size: 0.75rem;
        color: var(--dark-grey);
        letter-spacing: 1px;
        text-align: center;
    }

    .profile-rhs {
        flex: 1;
        background: var(--white);
        border: 1px solid #dcdcdc;
        border-radius: 14px;
        padding: 40px 48px 48px;
        animation: fadeUp .35s ease both;
    }
    .profile-headings {
        font-family: 'header';
        font-size: 1.4rem;
        color: var(--black);
    }
    .saveChanges-btn{
        background-color: transparent;
        border: none;
        color: var(--red);
        font-size: 0.8rem;
    }    
    .saveChanges-btn:hover{
        font-size: 0.82rem;
        font-weight: 700;
    } 
         
    /*  FORM GRID  */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 18px;
        }

        .field-wrap {
            position: relative;
        }

        .field-label {
            position: absolute;
            top: 50%;
            left: 18px;
            transform: translateY(-50%);
            font-size: 0.6rem;
            letter-spacing: 0.14em;
            color: #9e9e9e;
            pointer-events: none;
            transition: all 0.22s ease;
        }

        /* Float label when focused or filled */
        .field-wrap input:focus+.field-label,
        .field-wrap input:not(:placeholder-shown)+.field-label,
        .field-wrap select:focus+.field-label,
        .field-wrap select.has-value+.field-label {
            top: 12px;
            font-size: 0.5rem;
            color: var(--red);
        }

        .field-input, .field-select{
            width: 100%;
            height: 58px;
            border: 1.5px solid #dcdcdc;
            border-radius: 9px;
            background: var(--white);
            padding: 24px 18px 8px;
            font-family: 'sub';
            font-size: 0.65rem;
            letter-spacing: 0.06em;
            color: var(--dark-grey);
            outline: none;
            appearance: none;
            transition: border-color 0.22s ease, box-shadow 0.22s ease;
        }
        .field-input:focus,
        .field-select:focus {
            border-color: var(--dark-grey);
            box-shadow: 0 0 0 3px rgba(42, 42, 42, .06);
        }
        .field-select-wrap {
            position: relative;
        }

        .field-select-wrap .chevron {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #9e9e9e;
        }

        .field-wrap .show-pw-btn{
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
        }
</style>