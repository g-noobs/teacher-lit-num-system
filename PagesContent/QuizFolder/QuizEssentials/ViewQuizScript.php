<script>
$(function(){
    $(".quiz_info_btn").on('click', function(e){
        e.preventDefault();

        var btn_id = $(this).data('id');
        $('#quiz_id_data').text(btn_id);
        $.ajax({
            type: "POST",
            url: "../PagesContent/QuizFolder/ActionQuizFolder/ActionViewQuizData.php",
            data: {id: btn_id},
            success: function(response){
                var responseData = JSON.parse(response);

                $('#quiz_question_data').text(responseData.quiz_question);
                $('#correct_answer_data').text(responseData.correct_answer);
                $('#option1_data').text(responseData.option1);
                $('#option2_data').text(responseData.option2);
                $('#option3_data').text(responseData.option3);
                $('#topic_source_data').text(responseData.topic_source);
                $('#date_created_data').text(responseData.date_created);
                $('#quiz_status_data').text(responseData.quiz_status);
                


            },
            error:function(){
                console.log('Possible Ajx Issue');
            }
        });
    });
});
</script>