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
 
 Date: 18/08/2025 15:30:00
 */

-- ----------------------------
-- Sequence structure for user_payment_student_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_payment_student_id_seq";

CREATE SEQUENCE "public"."user_payment_student_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for user_payment_student
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_payment_student";

CREATE TABLE "public"."user_payment_student" (
    "id" int8 NOT NULL DEFAULT nextval('user_payment_student_id_seq' :: regclass),
    "user_payment_id" int8 NOT NULL,
    "student_id" int8 NOT NULL,
    "is_active" bool NOT NULL DEFAULT true,
    "start_date" date NOT NULL,
    "end_date" date,
    "access_level" varchar(20) COLLATE "pg_catalog"."default" DEFAULT 'full',
    "notes" text COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of user_payment_student
-- ----------------------------
-- Sample data for testing (assuming students with IDs 1, 2 exist)
INSERT INTO "public"."user_payment_student" VALUES (1, 1, 1, true, '2024-08-01', '2025-08-01', 'full', 'Student 1 linked to family package', 1, NULL, '2024-08-01 10:00:00', '2024-08-01 10:00:00');
INSERT INTO "public"."user_payment_student" VALUES (2, 1, 2, true, '2024-08-01', '2025-08-01', 'full', 'Student 2 linked to family package', 1, NULL, '2024-08-01 10:00:00', '2024-08-01 10:00:00');
INSERT INTO "public"."user_payment_student" VALUES (3, 2, 3, true, '2024-08-01', '2025-08-01', 'full', 'Student 3 linked to basic package', 1, NULL, '2024-08-01 11:00:00', '2024-08-01 11:00:00');

-- ----------------------------
-- Primary Key structure for table user_payment_student
-- ----------------------------
ALTER TABLE "public"."user_payment_student" ADD CONSTRAINT "user_payment_student_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Key structure for table user_payment_student
-- ----------------------------
ALTER TABLE "public"."user_payment_student" ADD CONSTRAINT "fk_user_payment_student_user_payment_id" FOREIGN KEY ("user_payment_id") REFERENCES "public"."user_payments" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."user_payment_student" ADD CONSTRAINT "fk_user_payment_student_student_id" FOREIGN KEY ("student_id") REFERENCES "public"."student" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."user_payment_student" ADD CONSTRAINT "fk_user_payment_student_created_by" FOREIGN KEY ("created_by") REFERENCES "public"."user" ("id") ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE "public"."user_payment_student" ADD CONSTRAINT "fk_user_payment_student_updated_by" FOREIGN KEY ("updated_by") REFERENCES "public"."user" ("id") ON DELETE SET NULL ON UPDATE CASCADE;

-- ----------------------------
-- Indexes for performance
-- ----------------------------
CREATE INDEX "idx_user_payment_student_user_payment_id" ON "public"."user_payment_student" USING btree ("user_payment_id");
CREATE INDEX "idx_user_payment_student_student_id" ON "public"."user_payment_student" USING btree ("student_id");
CREATE INDEX "idx_user_payment_student_is_active" ON "public"."user_payment_student" USING btree ("is_active");
CREATE INDEX "idx_user_payment_student_start_date" ON "public"."user_payment_student" USING btree ("start_date");
CREATE INDEX "idx_user_payment_student_end_date" ON "public"."user_payment_student" USING btree ("end_date");

-- ----------------------------
-- Unique constraint to prevent duplicate student-payment combinations
-- ----------------------------
CREATE UNIQUE INDEX "idx_user_payment_student_unique" ON "public"."user_payment_student" USING btree ("user_payment_id", "student_id");

-- ----------------------------
-- Check constraints for access levels
-- ----------------------------
ALTER TABLE "public"."user_payment_student" ADD CONSTRAINT "chk_access_level" CHECK (access_level IN ('full', 'limited', 'readonly'));

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_payment_student_id_seq" OWNED BY "public"."user_payment_student"."id";

SELECT setval('"public"."user_payment_student_id_seq"', 3, true);