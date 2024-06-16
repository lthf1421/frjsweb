<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Images Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .file-container {
            margin-top: 20px;
        }

        .file-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid transparent;
            /* Make table borders transparent */
        }

        .file-table th,
        .file-table td {
            border: 1px solid transparent;
            /* Make table cell borders transparent */
            padding: 8px;
            text-align: left;
        }

        .file-table th {
            background-color: #f2f2f2;
        }

        .file-actions {
            display: flex;
            align-items: center;
        }

        .delete-btn {
            color: red;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: color 0.3s ease;
            margin-right: 5px;
        }

        .delete-btn:hover {
            color: darkred;
        }

        .preview-img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2>Upload Images Form</h2>
        <form id="uploadForm" method="post" action="upload.php" enctype="multipart/form-data">

            <!-- Main Image -->
            <div class="form-group">
                <label for="mainImage">Main Image:</label>
                <input type="file" class="form-control-file" id="mainImage" name="mainImage">
                <div id="mainImagePreview" class="mt-2"></div>
            </div>

            <!-- Small Images -->
            <div class="form-group file-container">
                <label for="images">Small Images (up to 5):</label>
                <input type="file" class="form-control-file" id="images" name="images[]" multiple>
            </div>

            <!-- Selected Files -->
            <div id="fileNames"></div>

            <!-- Submit Button -->
            <button type="submit" id="submitBtn" class="btn btn-primary mt-3" style="display: none;">Submit</button>
        </form>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- JavaScript for handling file selection -->
    <script>
        $(document).ready(function() {
            // Global array to store selected files
            let selectedFiles = [];

            // Function to handle file selection and display file names
            function handleFileSelect(event) {
                const files = event.target.files;

                // Iterate through selected files
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    selectedFiles.push(file); // Add file to selectedFiles array
                }

                // Display file names in the fileNames container
                displayFileNames();

                // Show the submit button after files are selected
                document.getElementById("submitBtn").style.display = "block";
            }

            // Function to display file names in a table format with previews
            function displayFileNames() {
                const fileNamesContainer = document.getElementById("fileNames");
                fileNamesContainer.innerHTML = ""; // Clear previous content

                // Create table element
                const table = document.createElement("table");
                table.className = "file-table";

                // Create table header
                const header = table.createTHead();
                const headerRow = header.insertRow();
                const headerCell1 = headerRow.insertCell();
                headerCell1.textContent = "Selected Files";
                headerCell1.colSpan = "2";
                headerCell1.style.fontWeight = "bold";

                // Create table body
                const body = table.createTBody();
                selectedFiles.forEach(function(file, index) {
                    const row = body.insertRow();
                    const cell1 = row.insertCell();
                    const previewImg = document.createElement("img");
                    previewImg.className = "preview-img";
                    previewImg.src = URL.createObjectURL(file);
                    cell1.appendChild(previewImg);
                    const fileName = document.createElement("span");
                    fileName.textContent = file.name;
                    cell1.appendChild(fileName);
                    const cell2 = row.insertCell();
                    const deleteBtn = document.createElement("button");
                    deleteBtn.className = "delete-btn";
                    deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                    deleteBtn.addEventListener("click", function() {
                        deleteFile(row, index);
                    });
                    cell2.appendChild(deleteBtn);
                });

                // Append table to container
                fileNamesContainer.appendChild(table);
            }

            // Bind handleFileSelect function to file input change event
            document.getElementById("images").addEventListener("change", handleFileSelect, false);

            // Function to delete a file from the list
            function deleteFile(row, index) {
                // Remove file from selectedFiles array
                selectedFiles.splice(index, 1);
                // Remove row from table
                row.parentNode.removeChild(row);
            }

            // Function to display main image preview
            document.getElementById("mainImage").addEventListener("change", function(event) {
                const file = event.target.files[0];
                if (file) {
                    const mainImagePreview = document.getElementById("mainImagePreview");
                    mainImagePreview.innerHTML = ""; // Clear previous content
                    const previewImg = document.createElement("img");
                    previewImg.className = "preview-img";
                    previewImg.src = URL.createObjectURL(file);
                    mainImagePreview.appendChild(previewImg);
                }
            });

            // Submit form handler
            $("#uploadForm").submit(function(event) {
                // Prevent default form submission
                event.preventDefault();

                // Prepare FormData object
                const formData = new FormData();
                formData.append("mainImage", document.getElementById("mainImage").files[0]); // Add main image file
                for (let i = 0; i < selectedFiles.length; i++) {
                    formData.append("images[]", selectedFiles[i]); // Add all selected files
                }

                // Perform AJAX submit or use default form submission
                // Example using AJAX (jQuery):
                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success, e.g., clear file names container
                        $("#fileNames").empty();
                        // Clear main image preview
                        $("#mainImagePreview").empty();
                        // Hide submit button after upload
                        $("#submitBtn").hide();
                        // Optionally show success message or perform further actions
                        alert("Files uploaded successfully!");
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error("Upload error:", error);
                    }
                });
            });
        });
    </script>

</body>

</html>