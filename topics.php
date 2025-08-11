<?php
include_once ("connection.php");

$pure_topics = [];
$mech_topics = [];
$stats_topics = [];

$stmt = $conn->prepare("SELECT * FROM questions");
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $topic = $row['topic'];
    $area = $row['area'];

    if ($area == 0) {
        if (isset($pure_topics[$topic])) {
            $pure_topics[$topic]++;
        } else {
            $pure_topics[$topic] = 1;
        }
    } elseif ($area == 1) {
        if (isset($mech_topics[$topic])) {
            $mech_topics[$topic]++;
        } else {
            $mech_topics[$topic] = 1;
        }
    } elseif ($area == 2) {
        if (isset($stats_topics[$topic])) {
            $stats_topics[$topic]++;
        } else {
            $stats_topics[$topic] = 1;
        }
    }
}

arsort($pure_topics);
arsort($mech_topics);
arsort($stats_topics);


$data = [
    'pure' => $pure_topics,
    'mech' => $mech_topics,
    'stats' => $stats_topics,
];

file_put_contents('topics.json', json_encode($data, JSON_PRETTY_PRINT));
?>