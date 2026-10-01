/*
 Navicat Premium Data Transfer
 
 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 09/12/2024 21:40:04
 */
-- ----------------------------
-- Sequence structure for grade_level_class_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."grade_level_class_id_seq";

CREATE SEQUENCE "public"."grade_level_class_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for grade_level_class
-- ----------------------------
DROP TABLE IF EXISTS "public"."grade_level_class";

CREATE TABLE "public"."grade_level_class" (
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "class_section_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('grade_level_class_id_seq' :: regclass),
    "grade_level_id" int8
);

-- ----------------------------
-- Records of grade_level_class
-- ----------------------------
INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 1 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        1,
        1
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 3 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        3,
        2
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 2 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        2,
        3
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 4 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        4,
        4
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 5 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        5,
        5
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 6 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        6,
        6
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 7 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        7,
        7
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 8 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        8,
        8
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 9 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        9,
        9
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 10 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        10,
        10
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 11 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        11,
        11
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    (
        'Grade 12 - Class 1',
        NULL,
        NULL,
        NULL,
        NULL,
        12,
        12
    );

INSERT INTO
    "public"."grade_level_class"
VALUES
    ('EY 1 - Class 1', NULL, NULL, NULL, NULL, 13, 13);

INSERT INTO
    "public"."grade_level_class"
VALUES
    ('EY 2 - Class 1', NULL, NULL, NULL, NULL, 14, 14);

INSERT INTO
    "public"."grade_level_class"
VALUES
    ('EY 3 - Class 1', NULL, NULL, NULL, NULL, 15, 15);

-- ----------------------------
-- ----------------------------
-- Records of grade_level_class
-- ----------------------------
-- ----------------------------
-- Primary Key structure for table grade_level_class
-- ----------------------------
ALTER TABLE
    "public"."grade_level_class"
ADD
    CONSTRAINT "grade_level_class_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."grade_level_class_id_seq" OWNED BY "public"."grade_level_class"."id";

SELECT
    setval('"public"."grade_level_class_id_seq"', 15, true);