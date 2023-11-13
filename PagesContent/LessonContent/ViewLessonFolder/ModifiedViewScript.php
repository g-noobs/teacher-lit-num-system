<script>
$(function() {
    //Add class active on a selected sidebar menu
    $("#side-menu li a").on("click", function() {
        $(".sidebar-menu li.active").removeClass("active");
        $(this).closest("li").addClass("active");

        //get first li child of the sidebar-menu
        // var $firstli = $("#side-menu li:first-child");

        // $newLi = $firstli.clone();
        // //empty the span of the variable firstli
        // $newLi.find("span").empty();
        // //remove class from $firsli
        // $newLi.find("i").remove();

        // //add content to new li within span
        // $newLi.find("span").append('what to append');
        // // turn $firstli to string
        // $newLi = $($newLi).prop('outerHTML');
        // $('#side-menu').append($newLi);
    });

});
</script>