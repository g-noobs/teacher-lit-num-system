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
            dataType: 'json',
            success: function(response){
                
                //quiz type option's are 0, 1, 2 - modify the response to display the correct quiz type name
                if(response.quiz_type === '0'){
                    $('#quiz_type').text('Multiple Choice');

                }else if(response.quiz_type === '1'){
                    $('#quiz_type').text('True or False');
                }else if(response.quiz_type === '2'){
                    $('#quiz_type').text('Essay');
                }else{
                    $('#quiz_type').text('Unknown');
                }
                $('#quiz_question_data').text(response.quiz_question);
                $('#correct_answer_data').text(response.correct_answer);
                $('#option1_data').text(response.option1);
                $('#option2_data').text(response.option2);
                $('#option3_data').text(response.option3);
                $('#topic_source_data').text(response.topic_source);
                $('#date_created_data').text(response.date_created);
                $('#quiz_status_data').text(response.quiz_status);
    
            },
            error:function(){
                console.log('Possible Ajx Issue');
            }
        });
    });
});
</script>