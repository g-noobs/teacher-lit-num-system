<?php 

class DisplayGradebook extends Connection{
    function __construct(){
        parent :: __construct();
    }

    function gradebookData(){
        $connection= $this->getConnection();
        // Update tbl_learner_story_progress with topic IDs for each student
        $topicsQuery = "UPDATE tbl_learner_story_progress lsp
            JOIN tbl_user_info ui ON lsp.learner_id = ui.user_info_id
            SET lsp.story_id = ui.class_id
            WHERE ui.user_level_id = 2";
        mysqli_query($connection, $topicsQuery);

        // Update tbl_learner_story_progress with 'Not Taken Yet' for Date Completed
        $notTakenYetQuery = "UPDATE tbl_learner_story_progress
            SET date_completed = 'Not Taken Yet'
            WHERE date_completed IS NULL OR date_completed = '0000-00-00'";
        mysqli_query($connection, $notTakenYetQuery);

        // Query to fetch user information including class_id and class_name
        $query = "SELECT 
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

        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            // mao ni ang query for the result of total story taken by student
            $learnerId = $row['personal_id'];
            $topicsTakenQuery = "SELECT COUNT(DISTINCT lsp.story_id) AS total_topics FROM tbl_learner_story_progress lsp
                    JOIN tbl_topic t ON lsp.story_id = t.topic_id
                    WHERE lsp.learner_id = '$learnerId' AND t.topic_status = 1";
            $topicsTakenResult = mysqli_query($connection, $topicsTakenQuery);
            $topicsTakenRow = mysqli_fetch_assoc($topicsTakenResult);
            $totalTopicsTaken = mysqli_fetch_assoc($topicsTakenResult)['total_topics'];
            // mao ni ang query for the overall total result sa stories sa database
            $totalTopicsQuery = "SELECT COUNT(DISTINCT topic_id) AS total_topics FROM tbl_topic WHERE topic_status = 1";
            $totalTopicsResult = mysqli_query($connection, $totalTopicsQuery);
            $totalTopicsRow = mysqli_fetch_assoc($totalTopicsResult);
            $totalTopics = $totalTopicsRow['total_topics'];
            // mao ni ang query for the result of total quiz taken by student
            $quizTakenQuery = "SELECT learner_id, COUNT(DISTINCT quiz_id) AS total_quizzes FROM tbl_learner_quiz_progress WHERE learner_id = '$learnerId' AND quiz_id IN (SELECT quiz_id FROM tbl_quiz WHERE quiz_status = 1)";
            $quizTakenResult = mysqli_query($connection, $quizTakenQuery);
            $quizTakenRow = mysqli_fetch_assoc($quizTakenResult);
            $totalQuizTaken = $quizTakenRow['total_quizzes'];
            // mao ni ang query for the overall total result sa quizzes sa database
            $totalQuizQuery = "SELECT COUNT(DISTINCT quiz_id) AS total_quizzes FROM tbl_quiz WHERE quiz_status = 1";
            $totalQuizResult = mysqli_query($connection, $totalQuizQuery);
            $totalQuizRow = mysqli_fetch_assoc($totalQuizResult);
            $totalQuiz = $totalQuizRow['total_quizzes'];
            // mao ni ang query for the result of total assignment taken by student
            $assignmentTakenQuery = "SELECT COUNT(DISTINCT assignment_id) AS total_assignment FROM tbl_learner_assignment_progress WHERE learner_id = '$learnerId'";
            $assignmentTakenResult = mysqli_query($connection, $assignmentTakenQuery);
            $assignmentTakenRow = mysqli_fetch_assoc($assignmentTakenResult);
            $totalAssignmentTaken = $assignmentTakenRow['total_assignment'];
            // mao ni ang query for the overall total result sa assignments sa database
            $totalAssignmentQuery = "SELECT COUNT(DISTINCT assignment_id) AS total_assignment FROM tbl_assignment";
            $totalAssignmentResult = mysqli_query($connection, $totalAssignmentQuery);
            $totalAssignmentRow = mysqli_fetch_assoc($totalAssignmentResult);
            $totalAssignment = $totalAssignmentRow['total_assignment'];
        
    
        
            echo "<tr>
            <td class='personalId'>{$row['personal_id']}</td>
            <td class='firstName'>{$row['first_name']}</td>
            <td class='lastName'>{$row['last_name']}</td>
            <td class='gender'>{$row['gender']}</td>
            <td class='classSection'>{$row['class_name']}</td>
            <td class='topicsTaken'>$totalTopicsTaken out of $totalTopics</td>
            <td class='quizTaken'>$totalQuizTaken out of $totalQuiz</td>
            <td class='assignmentTaken'>$totalAssignmentTaken out of $totalAssignment</td>
            <td class='learnerProgress'><button type='button' class='btn btn-default' onclick=\"showProgress('{$row['user_info_id']}')\">Show Progress</button></td>
            <td class='quizProgress'><button type='button' class='btn btn-default' onclick=\"showQuizProgress('{$row['user_info_id']}')\">Show Quiz Progress</button></td>
            <td class='assignmentProgress'><button type='button' class='btn btn-default' onclick=\"showAssignmentProgress('{$row['user_info_id']}')\">Show Assignment Progress</button></td>
            <td><button type='button' class='btn btn-danger intervention_btn' data-id='{$row['user_info_id']}'>Add to Intervention</button></td>
        </tr>";
        }
        mysqli_close($connection);
    } 
}
?>

