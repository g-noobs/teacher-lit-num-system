<script>
$(function(){
  $('.viewBtn').on('click', function(e){
    e.preventDefault();
    var btn_id = $(this).data('id');

    $.ajax({
      type: "POST",
      url: "",
      data: {id: btn_id},
      success: function(response){
        var responseData = JSON.parse(response);
        
      },
      error:function(error){
        console.log('error');
      }
    });
  });
});
<script>
