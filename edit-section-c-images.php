<?php
session_start();

if (!(isset($_SESSION['id']) && $_SESSION['is_supervisor'] == "true")) { // Redirect the user to the log in page.
  header("Location: index.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <title>Edit Section C Images | iCompute</title>

    <!-- Styles -->

    <!-- Poppins Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />

    <!-- Foundation -->
    <link rel="stylesheet" href="_resources/css/foundation.css" />

    <!-- Custom Styles -->
    <link rel="stylesheet" href="_resources/css/main.css" />
    <style>
      h1, h2, h3, h4, h5, h6 {
        font-family: Poppins;
      }

      .card-product-hover-title {
        font-size: 1.4rem;
        font-weight: 400;
        margin-bottom: 0.2rem;
      }
      .card-product-hover {
        position: relative;
        line-height: 1.2rem;
        transition: all 0.35s ease;

        min-height: 125px;
      }
      .card-product-hover-details {
        -webkit-flex: 1 0 auto;
        -ms-flex: 1 0 auto;
        flex: 1 0 auto;
        padding: 1rem;
      }
      .card-product-hover-details > :last-child {
        margin-bottom: 0;
      }
      .card-product-hover-price {
        margin: 0.5rem 0;
        font-weight: 700;
        color: #1779ba;
        font-size: #1779ba;
      }
      .card-product-hover-icons {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 0.5rem;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-justify-content: flex-start;
        -ms-flex-pack: start;
        justify-content: flex-start;
      }
      .card-product-hover-icons a i {
        display: block;
        font-size: 1.5rem;
        line-height: 2.5rem;
        width: 2.5rem;
        background-color: #fefefe;
        text-align: center;
        color: #0a0a0a;
      }
      .card-product-hover-icons a i:hover {
        background-color: #8a8a8a;
        color: #fefefe;
        cursor: pointer;
      }
      .card-product-hover-icons a {
        margin: 2px;
        opacity: 0;
        -webkit-transform: translateY(50%);
        -ms-transform: translateY(50%);
        transform: translateY(50%);
        transition: all 0.35s ease;
      }
      .card-product-hover:hover a,
      .card-product-hover.hover a {
        transition: all 0.35s ease;
        opacity: 1;
        -webkit-transform: translateX(0);
        -ms-transform: translateX(0);
        transform: translateX(0);
      }
      .card-product-hover:hover a:nth-child(2),
      .card-product-hover.hover a:nth-child(2) {
        transition-delay: 0.1s;
      }
      .card-product-hover:hover a:nth-child(3),
      .card-product-hover.hover a:nth-child(3) {
        transition-delay: 0.2s;
      }
    </style>
  </head>

  <body>
    <?php
    include("_resources/php/navigation.php");
    ?>

    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div id="app" class="cell">
          <!-- Create Modal -->
          <div class="reveal" id="create-modal" data-reveal>
            <h3>Add a New Image</h3>

            <form id="adding-question-image-form" action="/_resources/php/section-c/adding-image.php" method="post" enctype="multipart/form-data">
              <label for="new-image">Image Uploader</label>
              <input type="file" name="new-image" />

              <label for="new-description">Description</label>
              <input type="text" name="new-description" />

              <!-- Save Button -->
              <button class="button success" title="Save this image."><i class="far fa-save fa-lg"></i></button>
            </form>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the create modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Edit Modal -->
          <div class="reveal" id="edit-modal" data-reveal>
            <h3>Edit Image</h3>

            <div v-if="fetchedImages.length != 0">
              <label>Image</label>
              <img :src="fetchedImages[editedImageIndex].path" :alt="fetchedImages[editedImageIndex].description" />

              <br /><br />

              <label for="edited-description">Description</label>
              <input type="text" name="edited-description" v-model="fetchedImages[editedImageIndex].description" />
            </div>

            <!-- Save Button -->
            <button class="button success" title="Save this image." v-on:click="saveImage()"><i class="far fa-save fa-lg"></i></button>

            <!-- Delete Button -->
            <button class="button alert" title="Delete this image." data-open="delete-modal" v-on:click="setDeletedImageIndex(editedImageIndex)"><i class="fas fa-trash-alt fa-lg"></i></button>

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the edit modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <!-- Delete Modal -->
          <div class="reveal" id="delete-modal" data-reveal>
            <h3>Confirmation</h3>

            <p>Type <strong>delete</strong> to delete the image.</p>
            <input type="text" name="delete-confirmation" v-model="deleteConfirmation" />

            <!-- Close Button -->
            <button class="close-button" data-close aria-label="Close modal." type="button" title="Close the delete modal."><span aria-hidden="true"><i class="far fa-times-circle"></i></span></button>
          </div>

          <h1>iCompute</h1>
          <h2>Administrative Access</h2>

          <img src="/_resources/images/analysis-banner.jpg" alt="Edit Section C Question Images Banner" />

          <h3>Edit Section C Images</h3>

          <hr />

          <div v-if="isLoading">
            <img src="_resources/images/loading-icon.gif" alt="Loading..." />
          </div>
          <div v-else>
            <!-- Create Button -->
            <button class="button" title="Create a question image." data-open="create-modal"><i class="fas fa-plus fa-lg"></i></button>

            <div class="grid-x grid-padding-x" data-equalizer>
              <div class="cell small-12 medium-3 large-3" v-for="(fetchedImage, index) in fetchedImages">
                <div class="card card-product-hover" data-equalizer-watch>
                  <img style="min-height: 268px;" :src="fetchedImage.path" :alt="fetchedImage.description" />

                  <div style="min-height: 107px;" class="card-product-hover-icons">
                    <!-- Edit Button -->
                    <a title="Edit this image." href="#" data-open="edit-modal" v-on:click="setEditedImageIndex(index)"><i class="fas fa-edit"></i></a>

                    <!-- Delete Button -->
                    <a title="Delete this image." href="#" data-open="delete-modal" v-on:click="setDeletedImageIndex(index)"><i class="fas fa-trash-alt"></i></a>
                  </div>

                  <div style="min-height: 108.8px;" class="card-product-hover-details">
                    <p>{{ fetchedImage.description }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Create Button -->
            <button class="button" title="Create a question image." data-open="create-modal" v-if="fetchedImages.length != 0"><i class="fas fa-plus fa-lg"></i></button>
          </div>
        </div>
      </div>
    </div>

    <!-- JavaScript Files -->

    <!-- jQuery -->
		<script type="text/javascript" src="_resources/js/vendor/jquery-3.3.1.js"></script>

    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <!-- Foundation -->
		<script type="text/javascript" src="_resources/js/vendor/foundation.min.js"></script>
		<script type="text/javascript" src="_resources/js/vendor/what-input.js"></script>
		<script>
		$(document).ready(function() {
			$(document).foundation();
		});
		</script>

    <!-- Fetching and Getting Data -->
		<script type="text/javascript" src="_resources/js/managing-data.js"></script>

    <!-- Section Script -->
    <script>
    var app = new Vue({
      el: '#app',

      data: {
        isLoading: true,

        fetchedImages: [],

        editedImageIndex: 0,

        deletedImageIndex: 0,

        deleteConfirmation: ""
      },

      methods: {
        deleteImage: function() {
          postData("_resources/php/section-c/deleting-image.php", this.fetchedImages[this.deletedImageIndex], "deleting");
          this.reset("section_c_images", "delete-modal");
          this.deleteConfirmation = "";
        },

        reset: function(tableName, divId) {
          this.isLoading = true;

          if (divId) {
            $("div#" + divId).foundation("close");
          }

          this.fetchedImages = [];
          fetchData(tableName, this.fetchedImages);

          let self = this; // "this" is not within the scope of setTimeout().
          setTimeout(function() {
            self.isLoading = false;
          }, 1000);


          Foundation.reInit($());
        },

        saveImage: function() {
          postData("_resources/php/section-c/saving-image.php", this.fetchedImages[this.editedImageIndex], "adding");
          this.reset("section_c_images", "edit-modal");
        },

        setDeletedImageIndex: function(index) {
          this.deletedImageIndex = index;
        },

        setEditedImageIndex: function(index) {
          this.editedImageIndex = index;
        }
      },

      mounted: function() {
        console.log("App mounted.");

        this.reset("section_c_images");
      },

      watch: {
        deleteConfirmation: function() {
          if (this.deleteConfirmation == "delete") {
            this.deleteImage();
          }
        },

        isLoading: function() {

        }
      }
    });
    </script>
  </body>
</html>
