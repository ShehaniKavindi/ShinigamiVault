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
        <!-- toast -->
        <div class="toast-msg" id="toast-msg">
            <i id="toast-icon" class="bi bi-x-circle-fill"></i>
            <span id="toast-text" class="toast-text"></span>
        </div>

        <div class="profile-details">
            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 1.5rem;">
                <h5 class="profile-headings">Profile Details</h5>
                <button class="saveChanges-btn" onclick="saveProfileDetails();">save profile details</button>
            </div>

            <div class="form-row">
                <!-- Full name -->
                <div class="field-wrap">
                    <input class="field-input" value="<?php echo $customer_data['fullname']; ?>" type="text" id="customer_fullname" placeholder=" " />
                    <label class="field-label" for="customer_fullname" >Fullname</label>
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
            <?php
            $address_rs = Database::search("
                SELECT 
                    a.line1, a.line2, a.city, a.postal_code, a.contact1, a.contact2,
                    a.district_id,
                    d.name as district_name,
                    p.name as province_name
                FROM address a
                LEFT JOIN district d ON d.id = a.district_id
                LEFT JOIN province p ON p.id = d.province_id
                WHERE a.customer_id = '$customer_id'
            ");
            $address_num = $address_rs->num_rows;
            $address_data = $address_rs->fetch_assoc();
            ?>
            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 1.5rem;">
                <h5 class="profile-headings">Shipping Details</h5>
                <button class="saveChanges-btn" onclick="saveAddressDetails();">save shipping details</button>
            </div>

            <div class="form-row">
                <!-- line 2 -->
                <div class="field-wrap">
                    <input class="field-input" value="<?php echo $address_data['line1'] ?? ''; ?>" type="text" id="line1" placeholder=" " />
                    <label class="field-label" for="" >Line 01</label>
                </div>
                <!-- line 2 -->
                <div class="field-wrap">
                    <input class="field-input" value="<?php echo $address_data['line2'] ?? ''; ?>" type="text" id="line2" placeholder=" " />
                    <label class="field-label" for="" >Line 02</label>
                </div>

                <!-- city -->
                <div class="field-wrap">
                    <input class="field-input" value="<?php echo $address_data['city'] ?? ''; ?>" type="text" id="city" placeholder=" " />
                    <label class="field-label" for="" >City</label>
                </div>
                

                <!-- disctrict -->
                    <div class="field-wrap field-select-wrap" onclick="checkProvince(event);">
                        <select class="field-select" id="district"  >
                            <option value="" disabled <?php echo $address_num == 0 ? 'selected' : ''; ?> hidden></option>
                            <?php if($address_num > 0) { ?>
                                <option value="<?php echo $address_data['district_id']; ?>" selected>
                                    <?php echo $address_data['district_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label class="field-label" for="district">District</label>
                        <span class="chevron">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </span>
                    </div>

                <!-- provice -->
                <?php 
                $province_rs = Database::search("SELECT id, name FROM province ORDER BY name");
                    ?>
                    <div class="field-wrap field-select-wrap">
                        <select class="field-select" id="province" onchange="loadDistricts(this.value)">
                            <option value="" disabled <?php echo $address_num == 0 ? 'selected' : ''; ?> hidden></option>
                            <?php while($p = $province_rs->fetch_assoc()) { ?>
                                <option value="<?php echo $p['id']; ?>"
                                    <?php echo (($address_data['province_name'] ?? '') == $p['name']) ? 'selected' : ''; ?>>
                                    <?php echo $p['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label class="field-label" for="province">Province</label>
                        <span class="chevron">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </span>
                    </div>

                <!-- postal code -->
                <div class="field-wrap">
                    <input class="field-input" value="<?php echo $address_data['postal_code'] ?? ''; ?>" type="text" id="pcode" placeholder=" " />
                    <label class="field-label" for="" >Postal code</label>
                </div>

                <!-- contact -->
                <div class="field-wrap">
                    <input class="field-input" value="<?php echo $address_data['contact1'] ?? ''; ?>" type="text" id="contact1" placeholder=" " />
                    <label class="field-label" for="" >Contact 1</label>
                </div>

                <!-- contact -->
                <div class="field-wrap">
                    <input class="field-input" value="<?php echo $address_data['contact2'] ?? ''; ?>" type="text" id="contact2" placeholder=" " />
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

        document.querySelectorAll('.field-select').forEach(select => {
            if (select.value !== '') select.classList.add('has-value');
            select.addEventListener('change', function() {
                this.classList.toggle('has-value', this.value !== '');
            });
        });

        window.addEventListener('load', function() {
            var province = document.getElementById('province');
            if (province.value !== '') {
                loadDistricts(province.value, <?php echo $address_data['district_id'] ?? 'null'; ?>);
            }
        });

        function checkProvince(event) {
            var province = document.getElementById('province').value;
            if (!province) {
                event.preventDefault();
                showToast('⚠ Please select a province first');
            }
        }

        function loadDistricts(provinceId, selectedId = null) {
            var districtSelect = document.getElementById('district');
            districtSelect.disabled = true;
            districtSelect.innerHTML = '<option value="" disabled selected hidden></option>';

            if (!provinceId) return;

            var req = new XMLHttpRequest();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    var districts = JSON.parse(req.responseText);
                    districts.forEach(function(d) {
                        var selected = selectedId && d.id == selectedId ? 'selected' : '';
                        districtSelect.innerHTML += '<option value="' + d.id + '" ' + selected + '>' + d.name + '</option>';
                    });
                    districtSelect.disabled = false;
                    if (selectedId) districtSelect.classList.add('has-value');
                }
            }
            req.open('GET', 'processes/getDistrictsProcess.php?province_id=' + provinceId, true);
            req.send();
        }

        function saveProfileDetails() {
            var fullname = document.getElementById('customer_fullname').value.trim();
            
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    var response = request.responseText;
                    if (response == "success") {
                        showToast("Profile updated! ✓", "success");
                        location.reload();
                    } else {
                        showToast("⚠ " + response);
                    }
                }
            }
            request.open("POST", "processes/customerProfileDetailsProcess.php", true);
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            request.send("fullname=" + encodeURIComponent(fullname));
        }

        function saveAddressDetails() {
            var line1    = document.getElementById('line1').value.trim();
            var line2    = document.getElementById('line2').value.trim();
            var city     = document.getElementById('city').value.trim();
            var district = document.getElementById('district').value;
            var province = document.getElementById('province').value;
            var pcode    = document.getElementById('pcode').value.trim();
            var contact1 = document.getElementById('contact1').value.trim();
            var contact2 = document.getElementById('contact2').value.trim();

            if (!line1)    { showToast('⚠ Line 01 cannot be empty'); return; }
            if (!city)     { showToast('⚠ City cannot be empty'); return; }
            if (!province) { showToast('⚠ Please select a province'); return; }
            if (!district) { showToast('⚠ Please select a district'); return; }
            if (!contact1) { showToast('⚠ Contact 1 cannot be empty'); return; }

            var form = new FormData();
            form.append('line1', line1);
            form.append('line2', line2);
            form.append('city', city);
            form.append('district', district);
            form.append('province', province);
            form.append('pcode', pcode);
            form.append('contact1', contact1);
            form.append('contact2', contact2);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.responseText == 'success') {
                        showToast('Address saved! ✓', 'success');
                        location.reload();
                    } else {
                        showToast('⚠ ' + request.responseText);
                    }
                }
            }
            request.open('POST', 'processes/customerAddressDetails.php', true);
            request.send(form);
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

        .field-input,
        .field-select{
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