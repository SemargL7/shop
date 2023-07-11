@extends('layouts.layout')
@section('title', 'Home')
@section('main_content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
        rel="stylesheet"
    />
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Create new item</h1>
            </div>

            <div class="col-md-12">

                <form method="post" action="/admin/createNewItem" class="mx-auto w-100" onsubmit="submitForm(event)" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select a category</option>
                            @if($categories)
                                @foreach ($categories['data'] as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                              @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_id">Product</label>
                        <select name="product_id" id="product_id" class="form-control" disabled>
                            <option value="">Select a product</option>
                        </select>
                    </div>
                    <label for="item_name">Item name</label>
                    <input type="text" name="item_name" id="item_name" placeholder="Item name" class="form-control">
                    <input type="text" name="item_crm_id" id="item_crm_id" placeholder="Item cmr id" hidden="hidden"
                           class="form-control" readonly>
                    <label for="item_number">Item number</label>
                    <input type="text" name="item_number" id="item_number" placeholder="Item number" class="form-control">
                    <label for="item_facebook_pixel">Item facebook pixel</label>
                    <input type="text" name="item_facebook_pixel" id="item_facebook_pixel" placeholder="Item facebook pixel"
                           class="form-control">

                    <div class="container">
                        <div class="options">
                            <!-- Text Format -->
                            <button id="bold" class="option-button format" type="button">
                                <i class="fa-solid fa-bold"></i>
                            </button>
                            <button id="italic" class="option-button format" type="button">
                                <i class="fa-solid fa-italic"></i>
                            </button>
                            <button id="underline" class="option-button format" type="button">
                                <i class="fa-solid fa-underline"></i>
                            </button>
                            <button id="strikethrough" class="option-button format" type="button">
                                <i class="fa-solid fa-strikethrough"></i>
                            </button>
                            <button id="superscript" class="option-button script" type="button">
                                <i class="fa-solid fa-superscript"></i>
                            </button>
                            <button id="subscript" class="option-button script" type="button">
                                <i class="fa-solid fa-subscript"></i>
                            </button>

                            <!-- List -->
                            <button id="insertOrderedList" class="option-button" type="button">
                                <div class="fa-solid fa-list-ol"></div>
                            </button>
                            <button id="insertUnorderedList" class="option-button" type="button">
                                <i class="fa-solid fa-list"></i>
                            </button>

                            <!-- Undo/Redo -->
                            <button id="undo" class="option-button" type="button">
                                <i class="fa-solid fa-rotate-left"></i>
                            </button>
                            <button id="redo" class="option-button" type="button">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>

                            <!-- Link -->
                            <button id="createLink" class="adv-option-button" type="button">
                                <i class="fa fa-link"></i>
                            </button>
                            <button id="unlink" class="option-button" type="button">
                                <i class="fa fa-unlink"></i>
                            </button>

                            <!-- Alignment -->
                            <button id="justifyLeft" class="option-button align" type="button">
                                <i class="fa-solid fa-align-left"></i>
                            </button>
                            <button id="justifyCenter" class="option-button align" type="button">
                                <i class="fa-solid fa-align-center"></i>
                            </button>
                            <button id="justifyRight" class="option-button align" type="button">
                                <i class="fa-solid fa-align-right"></i>
                            </button>
                            <button id="justifyFull" class="option-button align" type="button">
                                <i class="fa-solid fa-align-justify"></i>
                            </button>
                            <button id="indent" class="option-button spacing" type="button">
                                <i class="fa-solid fa-indent"></i>
                            </button>
                            <button id="outdent" class="option-button spacing" type="button">
                                <i class="fa-solid fa-outdent"></i>
                            </button>

                            <!-- Headings -->
                            <select id="formatBlock" class="adv-option-button">
                                <option value="H1">H1</option>
                                <option value="H2">H2</option>
                                <option value="H3">H3</option>
                                <option value="H4">H4</option>
                                <option value="H5">H5</option>
                                <option value="H6">H6</option>
                            </select>

                            <!-- Font -->
                            <select id="fontName" class="adv-option-button"></select>
                            <select id="fontSize" class="adv-option-button"></select>

                            <!-- Color -->
                            <div class="input-wrapper">
                                <input type="color" id="foreColor" class="adv-option-button" />
                                <label for="foreColor">Font Color</label>
                            </div>
                            <div class="input-wrapper">
                                <input type="color" id="backColor" class="adv-option-button" />
                                <label for="backColor">Highlight Color</label>
                            </div>
                        </div>
                        <h5>Description</h5>
                        <div id="text-input-description" class="border rounded"  contenteditable="true" style="min-height: 200px"></div>
                        <input type="text" name="description" id="description" class="form-control" hidden="hidden">
                        <h5>How to use</h5>
                        <div id="text-input-howtouse" class="border rounded"  contenteditable="true" style="min-height: 200px"></div>
                        <input type="text" name="howtouse" id="howtouse" class="form-control" hidden="hidden">

                    </div>
                    <label for="characteristics">Characteristics</label>
                    <div class="characteristics">
                        <div class="m-2">
                            <input type="text" name="characteristics[]" placeholder="Characteristic" class="form-control">
                            <input type="text" name="value[]" placeholder="Value" class="form-control">
                        </div>
                    </div>
                    <button id="addCharacteristicButton" class="btn btn-dark m-1" type="button">Add Characteristic</button>
                    <div>
                        <label for="image">Images</label>
                        <input type="file" class="form-control-file" multiple name="image[]" id="image">
                    </div>


                    <button type="submit" class="btn btn-dark form-control mt-4">Submit</button>
                </form>
            </div>

        </div>
    </div>
    <script>
        // JavaScript code
        $('#category_id').change(function () {
            var category_id = $(this).val();
            var productSelect = $('#product_id');
            var itemCrmIdInput = $('#item_crm_id');
            var itemNameInput = $('#item_name');

            if (category_id !== '') {
                // Disable the product selector
                productSelect.prop('disabled', true);

                // Make the AJAX request
                $.ajax({
                    url: '/api/getProductsByCategory',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        category_id: category_id
                    },
                    success: function (response) {
                        var products = response;
                        // Update the product list on the page
                        productSelect.html('<option value="">Select a product</option>');

                        $.each(products, function (index, product) {
                            var option = $('<option>').val(product.id).text(product.name);
                            productSelect.append(option);
                        });

                        // Re-enable the product selector
                        productSelect.prop('disabled', false);
                    }
                });
            } else {
                // Reset the product selector if no category is selected
                productSelect.html('<option value="">Select a product</option>');
            }
        });

        document.getElementById('product_id').addEventListener('change', function () {
            var selectedProduct = this.options[this.selectedIndex];
            var itemCrmIdInput = document.getElementById('item_crm_id');
            var itemNameInput = document.getElementById('item_name');

            if (selectedProduct.value !== '') {
                // Update the item_crm_id input with the selected product's ID
                itemCrmIdInput.value = selectedProduct.value;
                // Update the item_name input with the selected product's name
                itemNameInput.value = selectedProduct.textContent;
            } else {
                // Reset the item_crm_id and item_name inputs if no product is selected
                itemCrmIdInput.value = '';
                itemNameInput.value = '';
            }
        });
    </script>
    <script>
        function submitForm(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Get the inner HTML of the description and howtouse divs
            var descriptionHTML = document.getElementById("text-input-description").innerHTML;
            var howToUseHTML = document.getElementById("text-input-howtouse").innerHTML;

            // Set the HTML content as text values of the corresponding hidden inputs
            document.getElementById("description").value = descriptionHTML;
            document.getElementById("howtouse").value = howToUseHTML;

            // Submit the form
            event.target.submit();
        }
    </script>


    <script>
        document.getElementById('addCharacteristicButton').addEventListener('click', function () {
            var characteristicsDiv = document.querySelector('.characteristics');
            var newCharacteristicDiv = document.createElement('div');
            newCharacteristicDiv.classList.add('m-2')
            newCharacteristicDiv.innerHTML = `
            <input type="text" name="characteristics[]" placeholder="Characteristic" class="form-control">
            <input type="text" name="value[]" placeholder="Value" class="form-control">
        `;
            characteristicsDiv.appendChild(newCharacteristicDiv);
        });
    </script>
    <script>
        let optionsButtons = document.querySelectorAll(".option-button");
        let advancedOptionButton = document.querySelectorAll(".adv-option-button");
        let fontName = document.getElementById("fontName");
        let fontSizeRef = document.getElementById("fontSize");
        let writingArea = document.getElementById("text-input");
        let linkButton = document.getElementById("createLink");
        let alignButtons = document.querySelectorAll(".align");
        let spacingButtons = document.querySelectorAll(".spacing");
        let formatButtons = document.querySelectorAll(".format");
        let scriptButtons = document.querySelectorAll(".script");

        //List of fontlist
        let fontList = [
            "Arial",
            "Verdana",
            "Times New Roman",
            "Garamond",
            "Georgia",
            "Courier New",
            "cursive",
        ];

        //Initial Settings
        const initializer = () => {
            //function calls for highlighting buttons
            //No highlights for link, unlink,lists, undo,redo since they are one time operations
            highlighter(alignButtons, true);
            highlighter(spacingButtons, true);
            highlighter(formatButtons, false);
            highlighter(scriptButtons, true);

            //create options for font names
            fontList.map((value) => {
                let option = document.createElement("option");
                option.value = value;
                option.innerHTML = value;
                fontName.appendChild(option);
            });

            //fontSize allows only till 7
            for (let i = 1; i <= 7; i++) {
                let option = document.createElement("option");
                option.value = i;
                option.innerHTML = i;
                fontSizeRef.appendChild(option);
            }

            //default size
            fontSizeRef.value = 3;
        };

        //main logic
        const modifyText = (command, defaultUi, value) => {
            //execCommand executes command on selected text
            document.execCommand(command, defaultUi, value);
        };

        //For basic operations which don't need value parameter
        optionsButtons.forEach((button) => {
            button.addEventListener("click", () => {
                modifyText(button.id, false, null);
            });
        });

        //options that require value parameter (e.g colors, fonts)
        advancedOptionButton.forEach((button) => {
            button.addEventListener("change", () => {
                modifyText(button.id, false, button.value);
            });
        });

        //link
        linkButton.addEventListener("click", () => {
            let userLink = prompt("Enter a URL");
            //if link has http then pass directly else add https
            if (/http/i.test(userLink)) {
                modifyText(linkButton.id, false, userLink);
            } else {
                userLink = "http://" + userLink;
                modifyText(linkButton.id, false, userLink);
            }
        });

        //Highlight clicked button
        const highlighter = (className, needsRemoval) => {
            className.forEach((button) => {
                button.addEventListener("click", () => {
                    //needsRemoval = true means only one button should be highlight and other would be normal
                    if (needsRemoval) {
                        let alreadyActive = false;

                        //If currently clicked button is already active
                        if (button.classList.contains("active")) {
                            alreadyActive = true;
                        }

                        //Remove highlight from other buttons
                        highlighterRemover(className);
                        if (!alreadyActive) {
                            //highlight clicked button
                            button.classList.add("active");
                        }
                    } else {
                        //if other buttons can be highlighted
                        button.classList.toggle("active");
                    }
                });
            });
        };

        const highlighterRemover = (className) => {
            className.forEach((button) => {
                button.classList.remove("active");
            });
        };

        window.onload = initializer();
    </script>
@endsection
