<style>
/* Style for the alert */
#errorBanner, #successBanner{
    display: none;
    opacity: 0.75;
    position: fixed;
    /* Make it a fixed position */
    top: 1;
    /* Align to the top of the viewport */
    right: 0;
    /* Align to the left of the viewport */
    width: 65%;
    /* Full width */
    z-index: 1000;
    /* Set a high z-index to ensure it's on top of other elements */
}
</style>

<div class="alert alert-danger alert-dismissible fade in" id="errorBanner">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <b>Error! </b> <span id="errorAlert"></span>
</div>

<div class="alert alert-success alert-dismissible fade in" id="successBanner">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <b>Nice!</b> <span id="successAlert"></span>
</div>