<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Profile</title>
        <link
            rel="shortcut icon"
            href="image/01_header/favicon.ico"
            type="image/x-icon"
        />
        <!-- fontawsome cdn link -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        />
        <!-- css links -->
        <!--         <link
            rel="stylesheet"
            href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
            type="text/css"
        /> -->

        <link rel="stylesheet" href="../css/layout.css" />
        <link rel="stylesheet" href="../css/nav.css" />
        <link rel="stylesheet" href="../css/footer.css" />
        <link rel="stylesheet" href="../css/hero.css" />
        <link rel="stylesheet" href="../css/auction.css" />
        <link rel="stylesheet" href="../css/item.css" />
        <link rel="stylesheet" href="../css/profile.css" />
    </head>
    <body>
        <!-- header start -->
        <?php
            include '../components/navbar.php';
        ?>
        <!-- header end -->
        <!-- main start -->
        <main id="main">

            <section id="Item">
                <div class="container">

                    <div class="Item__wrapper">
                        <div class="item--title">
                            <h2>Edit Profile</h2>
                        </div>
                        <div class="item--nav">
                            <ul class="item--breadcrumbs">
                                <li><a href="#">Home </a></li>
                                /
                                <li><a href="#">Pages </a></li>
                                /
                                <li><a href="#">Author </a></li>
                                /
                                <li>Edit Profile</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section id="editProfile">
                <div class="container">
                    <div class="editProfile__left">
                        <div class="editProfile__left--avatar">
                            <div class="avatar">
                                <img
                                    src="image/09_Cover Image/imgslider.png"
                                    alt=""
                                    id="avatar"
                                />
                            </div>
                            <form action="/file-upload" id="formUploadPhoto">
                                <input type="file" name="" class="" />
                                <a href="#" class="btn btn--borderColor">
                                    <span>Upload new photo</span>
                                </a>
                            </form>
                            <a
                                href="#"
                                class="btn btn--borderColor"
                                id="deleteBtn"
                            >
                                <span>Delete</span>
                            </a>
                        </div>
                    </div>
                    <div class="editProfile__right">
                        <div class="editProfile__right--top">
                            <div class="editProfile__right--coverImageTitle">
                                <h3>Choice your Cover image</h3>
                            </div>
                            <div class="editProfile__right--coverImage">
                                <form action="/file-upload" id="formUploadFile">
                                    <input type="file" name="file" />
                                    <h4>Drag & Drop to Upload File</h4>
                                    <a href="#" class="btn btn--borderColor">
                                        <span>Choose files</span>
                                    </a>
                                </form>
                                <img
                                    id="cover"
                                    src="image/09_Cover Image/option1_bg_profile.jpg"
                                    alt=""
                                />
                                <img
                                    src="image/09_Cover Image/option2_bg_profile.jpg"
                                    alt=""
                                />
                            </div>
                        </div>
                        <div class="editProfile__right--bottom">
                            <div class="editProfile__right--account">
                                <div class="editProfile__right--accountInfo">
                                    <h3>Account info</h3>
                                    <div class="editProfile__account">
                                        <label for="name">Display name</label>
                                        <input
                                            type="text"
                                            name="name"
                                            id=""
                                            placeholder="Trista Francis"
                                            autocomplete="off"
                                        />
                                    </div>
                                    <div class="editProfile__account">
                                        <label for="url">Custom URL</label>
                                        <input
                                            type="text"
                                            name="url"
                                            id=""
                                            placeholder="Axies.Trista Francis.com/"
                                            autocomplete="off"
                                        />
                                    </div>
                                    <div class="editProfile__account">
                                        <label for="email">Email</label>
                                        <input
                                            placeholder="Enter your email"
                                            type="email"
                                            name="email"
                                            id=""
                                            autocomplete="off"
                                        />
                                    </div>
                                    <div class="editProfile__account">
                                        <label for="bio">Bio</label>
                                        <textarea
                                            name="bio"
                                            id=""
                                            cols="30"
                                            rows="10"
                                            autocomplete="off"
                                        ></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="editProfile__right--updateBtn">
                                    <button type="submit" class="btn btn--borderColor">
                                        <span>Update profile</span>
                                    </button>
                                </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- scroll -->
        <div id="scroll--top">
            <i class="fa-solid fa-angle-up"></i>
        </div>
        <!-- scripts -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>

    </body>
</html>