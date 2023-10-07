<?php
$dob = $params['dob'] ?? '';
$birthParts = explode("/", $dob);
$day = $birthParts[0];
$month = $birthParts[1] ?? '';
$year = $birthParts[2] ?? '';
?>
<?php include_once 'header.php' ?>
<body>
<div class="container">
    <div class="sidebar">
        <ul>
            <li>
                <?php if (!empty($params['image'])) : ?>
                    <img src="<?php echo $params['image']; ?>" style="height: 60px; width: 60px; border-radius: 50%; padding-left: 15px" />
                <?php else : ?>
                    <i class="fa-regular fa-user" style="font-size: 45px; border-radius: 50%; padding-left: 23px"></i>
                <?php endif; ?>
            </li>
            <li class="sidebar-btn">
                <i class="fa-solid fa-user-tie"></i>
                <span>Account</span>
            </li>

            <li class="sidebar-btn">
                <i class="fa-solid fa-bell"></i>
                <span>Notification</span>
            </li>

            <li class="sidebar-btn">
                <i class="fa-solid fa-users"></i>
                <span>Members</span>
            </li>
            <li class="sidebar-btn">
                <i class="fa-solid fa-layer-group"></i>
                <span>Groups</span>
            </li>
            <li class="sidebar-btn">
                <i class="fa-solid fa-square-caret-up"></i>
                <span>Guests</span>
            </li>
            <li class="sidebar-btn">
                <i class="fa-solid fa-server"></i>
                <span>Applications</span>
            </li>
        </ul>

        <a class="sidebar-logout sidebar-btn" href="/logout">
            <i class="fa-solid fa-power-off"></i>
            Logout
        </a>
    </div>
    <div class="all">
        <div class="wrapper">
            <div class="content-container">
                <div class="header">
                    <div class="header-left">
                        <button class="back-btn" style="height: 30px;">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>

                        <div class="account">
                            <span class="account-acc">ACCOUNT</span>
                            <div class="account-username"><?php echo $params['lastname'] . " " . $params['firstname'] ?>
                                · <?php echo $params['title'] ?></div>
                        </div>
                    </div>
                    <div class="header-right">

                        <button class="btn" id="myBtn">
                            <i class="fa-solid fa-arrow-up"></i>
                            <span>Edit my account</span>
                        </button>

                    </div>
                </div>
                <div class="content">
                    <div class="profile">
                        <div class="profile-info">
                            <div class="avatar">
                                <?php if (!empty($params['image'])) : ?>
                                    <img src="<?php echo $params['image']; ?>" style="height: 120px; width: 120px; border-radius: 50%" />
                                <?php else : ?>
                                    <i class="fa-regular fa-user"></i>
                                <?php endif; ?>
                            </div>
                            <div class="info">
                                <div class="info-name"><?php echo $params['lastname'] . " " . $params['firstname'] ?></div>
                                <div class="info-title"><?php echo $params['title'] ?></div>
                                <div class="info-email">
                                    <div class="info-add-phone">Email address</div>
                                    <div class="detail-add"><?php echo $params['email'] ?></div>
                                </div>
                                <div class="info-email">
                                    <div class="info-add-phone">Phone number</div>
                                    <div class="detail-add"><?php echo $params['phone'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact">
                        <div class="title">Contact info</div>
                        <div class="contact-info">
                            <b>Address</b>
                            <span><?php echo $params['address'] ?></span>
                        </div>
                    </div>
                    <div class="contact">
                        <div class="title">User groups (0)</div>
                    </div>
                    <div class="contact">
                        <div class="title">Direct Reports (0)</div>
                    </div>
                    <div class="contact">
                        <div class="title">
                            Education background
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="no-info">No information</div>
                    </div>
                    <div class="contact">
                        <div class="title">
                            Work experiences
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="no-info">No information</div>
                    </div>
                    <div class="contact">
                        <div class="title">
                            Honors and awards
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="no-info">No information</div>
                    </div>
                </div>
            </div>
            <div class="rightbar">
                <div class="rightbar-info">
                    <div class="rightbar-info-name"><?php echo $params['lastname'] . " " . $params['firstname'] ?></div>
                    <div class="rightbar-info-email">@<?php echo $params['username'] ?></div>
                </div>
                <div class="rightbar-account-info">
                    <div class="account-info">ACCOUNT INFORMATION</div>
                    <ul>
                        <li class="rightbar-btn">
                            <i class="fa-solid fa-gear"></i>
                            <span class="rightbar-btn-text">Account overview</span>
                        </li>
                        <li class="rightbar-btn">
                            <i class="fa-solid fa-pen"></i>
                            <span class="rightbar-btn-text">Edit account</span>
                        </li>
                        <li class="rightbar-btn">
                            <i class="fa-regular fa-compass"></i>
                            <span class="rightbar-btn-text">Edit language</span>
                        </li>
                        <li class="rightbar-btn">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span class="rightbar-btn-text">Edit password</span>
                        </li>
                        <li class="rightbar-btn">
                            <i class="fa-solid fa-circle-info"></i>
                            <span class="rightbar-btn-text">Edit theme color</span>
                        </li>
                        <li class="rightbar-btn">
                            <i class="fa-regular fa-clock"></i>
                            <span class="rightbar-btn-text">Set timesheet</span>
                        </li>
                        <li class="rightbar-btn">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span class="rightbar-btn-text">2-factor authentication</span>
                        </li>
                    </ul>
                </div>
                <div class="rightbar-security">
                    APPLICATION & SECURITY
                </div>
                <div class="rightbar-settings">
                    <div class="advance-setting">
                        ADVANCE SETTING
                    </div>
                    <ul>
                        <li class="rightbar-btn">
                            <i class="fa-solid fa-clock"></i>
                            <span class="rightbar-btn-text">Login histories</span>
                        </li>
                        <li class="rightbar-btn">
                            <i class="fa-solid fa-display"></i>
                            <span class="rightbar-btn-text">Manage linked devices</span>
                        </li>
                        <li class="rightbar-btn">
                            <i class="fa-solid fa-envelope"></i>
                            <span class="rightbar-btn-text">Edit email notification</span>
                        </li>
                        <li class="rightbar-btn">
                            <i class="fa-regular fa-clock"></i>
                            <span class="rightbar-btn-text">Edit timezone</span>
                        </li>
                        <li class="rightbar-btn">
                            <i class="fa-solid fa-clock"></i>
                            <span class="rightbar-btn-text">On-leave delegation</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal">
    <div class="modal-content" id="modal-content">
        <div class="modal-header">
            <div class="modal-header-text">Edit personal profile</div>
            <span id="close">&times;</span>
        </div>
        <form class="form" enctype="multipart/form-data">
            <div class="modal-form">
                <div class="form-row">
                    <div class="rows">
                        <div class="label">
                            Your first name
                            <div class="sublabel">Your first name</div>
                        </div>
                        <div class="input-data">
                            <input
                                    type="text"
                                    placeholder="your first name"
                                    name="first_name"
                                    value="<?php echo $params['firstname'] ?>"
                            />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <div class="label">
                            Your last name
                            <div class="sublabel">Your last name</div>
                        </div>
                        <div class="input-data">
                            <input
                                    type="text"
                                    placeholder="your last name"
                                    name="last_name"
                                    value="<?php echo $params['lastname'] ?>"
                            />
                        </div>
                    </div>
                    <div class="rows">
                        <div class="label">
                            Email
                            <div class="sublabel">Your email address</div>
                        </div>
                        <div class="input-data">
                            <div class="input-text"><?php echo $params['email'] ?></div>
                        </div>
                    </div>
                    <div class="rows">
                        <div class="label">
                            Username
                            <div class="sublabel">Your username</div>
                        </div>
                        <div class="input-data">
                            <div class="input-text">@<b><?php echo $params['username'] ?></b></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <div class="label">
                            Job title
                            <div class="sublabel">Job title</div>
                        </div>
                        <div class="input-data">
                            <input
                                    type="text"
                                    placeholder="Job title"
                                    name="title"
                                    value="<?php echo $params['title'] ?>"
                            />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <div class="label">
                            Profile image
                            <div class="sublabel">Profile image</div>
                        </div>
                        <div class="input-data">
                            <input type="file" name="image" class="input-file" value="<?php echo $params['image']?>"/>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <div class="label">
                            Date of birth
                            <div class="sublabel">Date of birth</div>
                        </div>
                        <div class="input-group">
                            <div class="gi">
                                <select name="day">
                                    <option value="--">-- Select date --</option>
                                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                                        <?php if ($i == $day) { ?>
                                            <option selected="selected"
                                                    value="<?php echo $i ?>"><?php echo $day ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="gi">
                                <select name="month">
                                    <option value="--">-- Select month --</option>
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <?php if ($i == $month) { ?>
                                            <option selected="selected"
                                                    value="<?php echo $i ?>"><?php echo $month ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="gi">
                                <select name="year">
                                    <option value="--">-- Select year --</option>
                                    <?php for ($i = 1930; $i <= 2010; $i++) { ?>
                                        <?php if ($i == $year) { ?>
                                            <option selected="selected"
                                                    value="<?php echo $i ?>"><?php echo $year ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="rows">
                        <div class="label">
                            Your phone number
                            <div class="sublabel">Your phone number</div>
                        </div>
                        <div class="input-data">
                            <input
                                    type="text"
                                    placeholder="Your phone number"
                                    name="phone"
                                    value="<?php echo $params['phone'] ?>"
                            />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <div class="label">
                            Current address
                            <div class="sublabel">Current address</div>
                        </div>
                        <div class="input-data">
									<textarea
                                            type="text"
                                            placeholder="Current address"
                                            name="address"
                                    ><?php echo $params['address'] ?></textarea
                                    >
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="form-button">
                    <div class="button">
                        <button class="cancel-button" id="cancel-button">Cancel</button>
                        <button class="update-button" type="submit">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="popup-pro" id="popup-pro">
    <div class="popup" id="popup">
        <div class="popup-content">
            <div class="popup-but">
                <div class="popup-test">
                    <i class="fa-solid fa-circle-question"></i>
                    <span id="result"></span>
                </div>
                <span id="closeErr">&times;</span>
            </div>
            <button type="button" id="btnOk">OK</button>
        </div>
    </div>
</div>
</body>
<script>
    var popup = document.getElementById("popup-pro");

    function openPopup() {
        popup.style.display = "block";
    }

    var btnCloseErr = document.getElementById("closeErr");
    btnCloseErr.onclick = function () {
        popup.style.display = "none";
    }
    var btnOk = document.getElementById("btnOk");
    btnOk.onclick = function () {
        popup.style.display = "none";

    }

    popup.onclick = function (event) {
        if (event.target == popup && event.target !== btnCloseErr) {
        }
    };

    <?php if(!empty($errors)) {?>
    showModal();
    <?php }?>

    var modal = document.getElementById("modal");
    var btn = document.getElementById("myBtn");
    btn.onclick = function () {
        modal.style.display = "block";
    };

    var cancelButton = document.getElementById("cancel-button");
    cancelButton.onclick = function () {
        modal.style.display = "none";
    };

    var btnClose = document.getElementById("close");
    btnClose.onclick = function () {
        modal.style.display = "none";
    };

    modal.onclick = function (event) {
        if (event.target == modal && event.target !== cancelButton) {
        }
    };

    $(document).ready(function () {
        $(".form").submit(function (event) {
            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "/update",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    response = JSON.parse(response);

                    $("#result").html(response.message);
                    console.log(response);
                    if (response["success"]) {
                        location.reload();
                    } else {
                        var spanResult = document.getElementById("result");
                        spanResult.textContent = response["message"];
                        openPopup();
                    }
                }
            });
        });
    });
</script>
</html>
