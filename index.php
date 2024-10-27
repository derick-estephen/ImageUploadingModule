<?php include 'functions.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Uploading Module</title>

    <!-- POPPINS FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- POPPINS FONT -->

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    container: {
                        center: true,
                        padding: {
                            DEFAULT: "1rem",
                            md: "1.5rem",
                            lg: "2rem",
                        }
                    },
                    fontFamily: {
                        poppins: "'Poppins', sans-serif",
                    },

                }
            }
        }
    </script>
    <style>
        ::-webkit-file-upload-button {
            background-color: #3b82f6;
            outline: none;
            border: none;
            padding: 8px 16px;
            border-start-start-radius: 0.5rem;
            color: white;
            margin-right: 12px;
            cursor: pointer;
        }
    </style>
</head>

<body class="font-poppins bg-zinc-900 text-zinc-100">


    <?php
    if (isset($_POST['submit'])) {

        $gal_imgs = $_FILES['gal_imgs'];

        // checks the directory exists or not, if not it makes the directory
        // change the path according to the directory structure
        if (!is_dir("imgs/gallery/")) {
            mkdir("imgs/gallery/");
        }

        // loop to upload multiple images
        // to upload single image use the code inside the loop
        for ($i = 0; $i < count($gal_imgs['name']); $i++) {
            $gal_img = explode(".", $gal_imgs['name'][$i]);
            $gal_img_new = rand(100000, 999999) . $gal_img[0] . ".webp";
            $gal_img_destination = "imgs/gallery/$gal_img_new";
            $gal_img_source = $gal_imgs['tmp_name'][$i];

            // covertToSize() will resize the image to the required size
            // accepts 4 parameters
            // 1. source of the image
            // 2. destination of the image
            // 3. width of the image
            // 4. height of the image
            convertToSize($gal_img_source, $gal_img_destination, 1280, 720);

            // convertToWebp() will compress the image by reducing its quality
            // accepts 3 parameters
            // 1. source of the image
            // 2. destination of the image
            // 3. quality of the image

            // in this case the source and destination of the image is same.
            convertToWebp($gal_img_destination, $gal_img_destination, 80);

            // these functions are defined in the functions.php file

            // The insert query for image comes here
            // use the $gal_img_new varible in insert query

        }

        $msg = "<div class='px-4 py-2 border border-green-500 text-center text-green-500 rounded-lg mb-12'>Images Uploaded Successfully</div>";
    
    }
    ?>

    <section>
        <div class="min-h-screen container py-16 flex items-center justify-center text-sm">
            <form method="POST" enctype="multipart/form-data">
                <?php
                if (isset($msg)) {
                    echo $msg;
                }
                ?>
                <input type="file" name="gal_imgs[]" multiple class="mb-6 border border-blue-500 rounded-lg"> <br>
                <button type="submit" name="submit" class="w-full px-4 py-2 bg-blue-500 rounded-lg">Submit</button>
            </form>
        </div>
    </section>

</body>

</html>