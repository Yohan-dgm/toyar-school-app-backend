/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v1
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 09/12/2024 10:15:35
 */

-- ----------------------------
-- Sequence structure for student_sport_history_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_sport_history_id_seq";

CREATE SEQUENCE "public"."student_sport_history_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_sport_history
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_sport_history";

CREATE TABLE "public"."student_sport_history" (
    "id" int8 NOT NULL DEFAULT nextval('student_sport_history_id_seq' :: regclass),
    "student_sport_id" int8 NOT NULL,
    "student_id" int8 NOT NULL,
    "sport_id" int8 NOT NULL,
    "coach_id" int8,
    "action_type" varchar(50) NOT NULL, -- 'enrolled', 'left', 'coach_changed', 'reactivated'
    "enrolled_date" date,
    "left_date" date,
    "reason" text,
    "notes" text,
    "created_by" int8,
    "created_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP
);

-- ----------------------------
-- Primary Key structure for table student_sport_history
-- ----------------------------
ALTER TABLE "public"."student_sport_history" 
ADD CONSTRAINT "student_sport_history_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes for performance
-- ----------------------------
CREATE INDEX "idx_student_sport_history_student_sport" ON "public"."student_sport_history" ("student_sport_id");
CREATE INDEX "idx_student_sport_history_student_id" ON "public"."student_sport_history" ("student_id");
CREATE INDEX "idx_student_sport_history_sport_id" ON "public"."student_sport_history" ("sport_id");
CREATE INDEX "idx_student_sport_history_action_type" ON "public"."student_sport_history" ("action_type");
CREATE INDEX "idx_student_sport_history_created_at" ON "public"."student_sport_history" ("created_at");

-- ----------------------------
-- Foreign Key Constraints
-- ----------------------------
-- Note: Foreign key constraints should be added based on your specific table relationships
-- ALTER TABLE "public"."student_sport_history" ADD CONSTRAINT "fk_student_sport_history_student_sport" FOREIGN KEY ("student_sport_id") REFERENCES "public"."student_sport" ("id");
-- ALTER TABLE "public"."student_sport_history" ADD CONSTRAINT "fk_student_sport_history_student" FOREIGN KEY ("student_id") REFERENCES "public"."student" ("id");
-- ALTER TABLE "public"."student_sport_history" ADD CONSTRAINT "fk_student_sport_history_sport" FOREIGN KEY ("sport_id") REFERENCES "public"."sport" ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_sport_history_id_seq" OWNED BY "public"."student_sport_history"."id";

SELECT setval('"public"."student_sport_history_id_seq"', 1, false);