<?php

namespace repository;

use models\Activity;
use PDO;
use Repository;

require_once 'Repository.php';
require_once __DIR__ . '/../models/Activity.php';

class ActivityRepository extends Repository
{
    public function getActivity(string $activity_name): ?Activity
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM public.activities WHERE activity_name = :activity_name');
        $stmt->bindParam(':activity_name', $activity_name, PDO::PARAM_STR);
        $stmt->execute();

        $activity = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($activity == false) {
            return null;
        }

        return new Activity(
            $activity['activity_name']
        );
    }

    public function getActivities(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('SELECT * FROM public.activities');
        $stmt->execute();
        $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($activities as $activity) {
            $result[] = new Activity(
                $activity['activity_name']
            );
        }

        return $result;
    }

    public function addActivity(Activity $activity): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO activities(activity_name)
            VALUES (?) RETURNING id
        ');

        $stmt->execute([
            $activity->getActivityName()
        ]);
    }
    public function getActivitiesByWeatherConditions($conditions, $limit): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT DISTINCT a.activity_name
            FROM activities a
            WHERE a.activity_name IN (:activities)
            LIMIT :limit
        ');

        $stmt->bindValue(':activities', implode(',', $activitiesByWeather[$weatherCondition]), PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $activities = [];
        foreach ($results as $result) {
            $activities[] = new Activity($result['activity_name']);
        }

        return $activities;
    }
}