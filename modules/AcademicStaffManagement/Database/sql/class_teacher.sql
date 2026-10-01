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

 Date: 14/10/2025
*/

-- ----------------------------
-- Sequence structure for class_teacher_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."class_teacher_id_seq";

CREATE SEQUENCE "public"."class_teacher_id_seq"
    INCREMENT 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    START 1
    CACHE 1;

-- ----------------------------
-- Table structure for class_teacher
-- ----------------------------
DROP TABLE IF EXISTS "public"."class_teacher";

CREATE TABLE "public"."class_teacher" (
    "id" bigint NOT NULL DEFAULT nextval('class_teacher_id_seq'::regclass),
    "user_id" bigint NOT NULL,
    "grade_level_class_id" bigint NOT NULL,
    "academic_year" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
    "start_date" date NOT NULL,
    "end_date" date,
    "is_active" boolean DEFAULT true,
    "created_by" bigint,
    "updated_by" bigint,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table class_teacher
-- ----------------------------
ALTER TABLE "public"."class_teacher"
    ADD CONSTRAINT "class_teacher_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Key structure for table class_teacher
-- ----------------------------
ALTER TABLE "public"."class_teacher"
    ADD CONSTRAINT "class_teacher_user_id_fkey" FOREIGN KEY ("user_id") REFERENCES "public"."user" ("id") ON DELETE CASCADE;

ALTER TABLE "public"."class_teacher"
    ADD CONSTRAINT "class_teacher_grade_level_class_id_fkey" FOREIGN KEY ("grade_level_class_id") REFERENCES "public"."grade_level_class" ("id") ON DELETE CASCADE;

ALTER TABLE "public"."class_teacher"
    ADD CONSTRAINT "class_teacher_created_by_fkey" FOREIGN KEY ("created_by") REFERENCES "public"."user" ("id") ON DELETE SET NULL;

ALTER TABLE "public"."class_teacher"
    ADD CONSTRAINT "class_teacher_updated_by_fkey" FOREIGN KEY ("updated_by") REFERENCES "public"."user" ("id") ON DELETE SET NULL;

-- ----------------------------
-- Indexes for better query performance
-- ----------------------------
CREATE INDEX "class_teacher_user_id_index" ON "public"."class_teacher" ("user_id");
CREATE INDEX "class_teacher_grade_level_class_id_index" ON "public"."class_teacher" ("grade_level_class_id");
CREATE INDEX "class_teacher_academic_year_index" ON "public"."class_teacher" ("academic_year");
CREATE INDEX "class_teacher_is_active_index" ON "public"."class_teacher" ("is_active");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."class_teacher_id_seq" OWNED BY "public"."class_teacher"."id";

-- ----------------------------
-- Initialize sequence value
-- ----------------------------
SELECT setval('"public"."class_teacher_id_seq"', 1, false);
