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
-- Sequence structure for grade_level_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."grade_level_id_seq";

CREATE SEQUENCE "public"."grade_level_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for grade_level
-- ----------------------------
DROP TABLE IF EXISTS "public"."grade_level";

CREATE TABLE "public"."grade_level" (
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('grade_level_id_seq' :: regclass)
);

-- ----------------------------
-- Records of grade_level
-- ----------------------------
INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 1',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        1
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 2',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        2
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 3',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        3
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 4',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        4
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 5',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        5
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 6',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        6
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 7',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        7
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 8',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        8
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 9',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        9
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 10',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        10
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 11',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        11
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Grade 12',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        12
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Early Year 1',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        13
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Early Year 2',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        14
    );

INSERT INTO
    "public"."grade_level"
VALUES
    (
        'Early Year 3',
        1,
        NULL,
        '2024-11-12 16:33:11',
        NULL,
        15
    );

-- ----------------------------
-- Primary Key structure for table grade_level
-- ----------------------------
ALTER TABLE
    "public"."grade_level"
ADD
    CONSTRAINT "grade_level_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."grade_level_id_seq" OWNED BY "public"."grade_level"."id";

SELECT
    setval('"public"."grade_level_id_seq"', 15, true);