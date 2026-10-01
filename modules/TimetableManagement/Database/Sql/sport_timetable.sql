-- ----------------------------
-- Sequence structure for sport_timetable_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."sport_timetable_id_seq";

CREATE SEQUENCE "public"."sport_timetable_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for sport_timetable
-- ----------------------------
DROP TABLE IF EXISTS "public"."sport_timetable";

CREATE TABLE "public"."sport_timetable" (
    "id" int8 NOT NULL DEFAULT nextval('sport_timetable_id_seq' :: regclass),
    "created_by" int8 NOT NULL,
    "updated_by" int8,
    "sport_id" int8 NOT NULL,
    "grade_level_id" int8,
    "coach_id" int8 NOT NULL,
    "day_of_week" VARCHAR(10) CHECK (
        day_of_week IN (
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday'
        )
    ),
    "start_time" TIME NOT NULL,
    "end_time" TIME NOT NULL,
    "venue" VARCHAR(100),
    "facility" VARCHAR(100),
    "season" VARCHAR(10) CHECK (
        season IN ('morning', 'afternoon', 'evening', 'night')
    ),
    "academic_year" VARCHAR(20) NOT NULL,
    "is_active" BOOLEAN DEFAULT true,
    "notes" TEXT,
    "team_id" int8,
    "max_participants" INT,
    "age_group" VARCHAR(50),
    "skill_level" VARCHAR(20) CHECK (
        skill_level IN ('beginner', 'intermediate', 'advanced', 'expert')
    ),
    "created_at" TIMESTAMP(0),
    "updated_at" TIMESTAMP(0)
);

-- ----------------------------
-- Primary Key structure for table sport_timetable
-- ----------------------------
ALTER TABLE
    "public"."sport_timetable"
ADD
    CONSTRAINT "sport_timetable_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."sport_timetable_id_seq" OWNED BY "public"."sport_timetable"."id";

-- ----------------------------
-- Optionally reset sequence (start from 1)
-- ----------------------------
SELECT
    setval('"public"."sport_timetable_id_seq"', 1, false);