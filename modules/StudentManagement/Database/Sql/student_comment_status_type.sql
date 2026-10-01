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
-- Sequence structure for educator_feedback_status_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."educator_feedback_status_type_id_seq";

CREATE SEQUENCE "public"."educator_feedback_status_type_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ---------------------------
-- Table structure for educator_feedback_status_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."educator_feedback_status_type";

CREATE TABLE "public"."educator_feedback_status_type" (
    "id" int8 NOT NULL DEFAULT nextval(
        'educator_feedback_status_type_id_seq' :: regclass
    ),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "sequential_order" int4
);

-- ----------------------------
-- Records of educator_feedback_status_type
-- ----------------------------
INSERT INTO
    "public"."educator_feedback_status_type"
VALUES
    (
        1,
        NULL,
        NULL,
        '2025-01-01 10:49:46',
        NULL,
        'Pending Approval',
        1
    );

INSERT INTO
    "public"."educator_feedback_status_type"
VALUES
    (
        2,
        NULL,
        NULL,
        '2025-01-01 10:49:46',
        NULL,
        'Approved',
        2
    );

INSERT INTO
    "public"."educator_feedback_status_type"
VALUES
    (
        3,
        NULL,
        NULL,
        '2025-01-01 10:49:46',
        NULL,
        'Rejected',
        3
    );

INSERT INTO
    "public"."educator_feedback_status_type"
VALUES
    (
        4,
        NULL,
        NULL,
        '2025-01-01 10:49:46',
        NULL,
        'Canceled',
        4
    );

-- ----------------------------
-- Primary Key structure for table educator_feedback_status_type
-- ----------------------------
ALTER TABLE
    "public"."educator_feedback_status_type"
ADD
    CONSTRAINT "educator_feedback_status_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."educator_feedback_status_type_id_seq" OWNED BY "public"."educator_feedback_status_type"."id";

SELECT
    setval(
        '"public"."educator_feedback_status_type_id_seq"',
        4,
        true
    );