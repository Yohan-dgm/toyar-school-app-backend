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
 
 Date: 09/12/2024 09:41:15
 */
-- ----------------------------
-- Sequence structure for student_supply_note_status_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_supply_note_status_type_id_seq";

CREATE SEQUENCE "public"."student_supply_note_status_type_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for student_supply_note_status_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."student_supply_note_status_type";

CREATE TABLE "public"."student_supply_note_status_type" (
    "id" int8 NOT NULL DEFAULT nextval(
        'student_supply_note_status_type_id_seq' :: regclass
    ),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "sequential_order" int4,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of student_supply_note_status_type
-- ----------------------------
INSERT INTO
    "public"."student_supply_note_status_type"
VALUES
    (
        1,
        'Pending',
        1,
        NULL,
        NULL,
        '2024-12-31 00:00:00',
        NULL
    );

INSERT INTO
    "public"."student_supply_note_status_type"
VALUES
    (
        2,
        'Received',
        2,
        NULL,
        NULL,
        '2024-12-31 00:00:00',
        NULL
    );

INSERT INTO
    "public"."student_supply_note_status_type"
VALUES
    (
        3,
        'Consumed',
        3,
        NULL,
        NULL,
        '2024-12-31 00:00:00',
        NULL
    );

-- ----------------------------
-- Primary Key structure for table student_supply_note_status_type
-- ----------------------------
ALTER TABLE
    "public"."student_supply_note_status_type"
ADD
    CONSTRAINT "student_supply_note_status_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_supply_note_status_type_id_seq" OWNED BY "public"."student_supply_note_status_type"."id";

SELECT
    setval(
        '"public"."student_supply_note_status_type_id_seq"',
        3,
        true
    );