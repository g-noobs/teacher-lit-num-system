<?php 

class DisplayGradebook extends Connection{
    function __construct(){
        parent :: __construct();
    }

    function gradebookData(){
        $conn= $this->getConnection();
        // Update tbl_learner_story_progress with topic IDs for each student
        $topicsQuery = "UPDATE tbl_learner_story_progress lsp
        JOIN tbl_user_info ui ON lsp.learner_id = ui.user_info_id
        SET lsp.story_id = ui.class_id
        WHERE ui.user_level_id = 2";

        mysqli_query($conn, $topicsQuery);

        // Update tbl_learner_story_progress with 'Not Taken Yet' for Date Completed
        $notTakenYetQuery = "
        UPDATE tbl_learner_story_progress
        SET date_completed = 'Not Taken Yet'
        WHERE date_completed IS NULL OR date_completed = '0000-00-00'
        ";

        mysqli_query($conn, $notTakenYetQuery);

        // Query to fetch user information including class_id and class_name
        $query = "
        SELECT 
            ui.user_info_id,
            ui.personal_id,
            ui.first_name,
            ui.last_name,
            ui.gender,
            ui.class_id,
            cls.class_name
        FROM 
            tbl_user_info ui
        LEFT JOIN
            tbl_class cls ON ui.class_id = cls.class_id
        WHERE 
            ui.user_level_id = 2
        ";

        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            // Fetch learner_id and calculate total topics taken
            $learnerId = $row['personal_id'];
            $topicsTakenQuery = "SELECT COUNT(DISTINCT story_id) AS total_topics FROM tbl_learner_story_progress WHERE learner_id = '$learnerId'";
            $topicsTakenResult = mysqli_query($conn, $topicsTakenQuery);
            $topicsTakenRow = mysqli_fetch_assoc($topicsTakenResult);
            $totalTopicsTaken = $topicsTakenRow['total_topics'];
            $totalTopicsQuery = "SELECT COUNT(DISTINCT topic_id) AS total_topics FROM tbl_topic";
            $totalTopicsResult = mysqli_query($conn, $totalTopicsQuery);
            $totalTopicsRow = mysqli_fetch_assoc($totalTopicsResult);
            $totalTopics = $totalTopicsRow['total_topics'];
    
            $quizTakenQuery = "SELECT learner_id, COUNT(DISTINCT quiz_id) AS total_quizzes FROM tbl_learner_quiz_progress WHERE learner_id = '$learnerId' AND quiz_id IN (SELECT quiz_id FROM tbl_quiz WHERE quiz_status = 1)";
            $quizTakenResult = mysqli_query($conn, $quizTakenQuery);
            $quizTakenRow = mysqli_fetch_assoc($quizTakenResult);
            $totalQuizTaken = $quizTakenRow['total_quizzes'];
            $totalQuizQuery = "SELECT COUNT(DISTINCT quiz_id) AS total_quizzes FROM tbl_quiz WHERE quiz_status = 1";
            $totalQuizResult = mysqli_query($conn, $totalQuizQuery);
            $totalQuizRow = mysqli_fetch_assoc($totalQuizResult);
            $totalQuiz = $totalQuizRow['total_quizzes'];
    
    
        
            echo "<tr>
                <td class='userInfoID'>{$row['user_info_id']}</td>
                <td class='personalID'>{$row['personal_id']}</td>
                <td class='firstName'>{$row['first_name']}</td>
                <td class='lastName'>{$row['last_name']}</td>
                <td class='gender'>{$row['gender']}</td>
                <td class='classSection'>{$row['class_name']}</td>
                <td class='topicsTaken'>$totalTopicsTaken out of $totalTopics</td>
                <td class='quizTaken'>$totalQuizTaken out of $totalQuiz</td>
                <td class='learnerProgress'><button class='btn btn-default' onclick=\"showProgress('{$row['user_info_id']}')\">Show Progress</button></td>
                <td class='quizProgress'><button class='btn btn-primary' onclick=\"showQuizProgress('{$row['user_info_id']}')\">Show Quiz Progress</button></td>
    
            </tr>";
        }
        mysqli_close($conn);
    } 
}
?>