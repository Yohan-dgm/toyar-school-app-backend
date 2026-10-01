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
-- Sequence structure for purchase_request_note_status_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."purchase_request_note_status_type_id_seq";

CREATE SEQUENCE "public"."purchase_request_note_status_type_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for purchase_request_note_status_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."purchase_request_note_status_type";

CREATE TABLE "public"."purchase_request_note_status_type" (
    "id" int8 NOT NULL DEFAULT nextval(
        'purchase_request_note_status_type_id_seq' :: regclass
    ),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "sequential_order" int4,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of purchase_request_note_status_type
-- ----------------------------
INSERT INTO
    "public"."purchase_request_note_status_type"
VALUES
    (
        1,
        'Pending Approval',
        1,
        NULL,
        NULL,
        '2024-12-31 00:00:00',
        NULL
    );

INSERT INTO
    "public"."purchase_request_note_status_type"
VALUES
    (
        2,
        'Approved',
        2,
        NULL,
        NULL,
        '2024-12-31 00:00:00',
        NULL
    );

INSERT INTO
    "public"."purchase_request_note_status_type"
VALUES
    (
        3,
        'Rejected',
        3,
        NULL,
        NULL,
        '2024-12-31 00:00:00',
        NULL
    );

INSERT INTO
    "public"."purchase_request_note_status_type"
VALUES
    (
        4,
        'Canceled',
        4,
        NULL,
        NULL,
        '2024-12-31 00:00:00',
        NULL
    );

-- ----------------------------
-- Primary Key structure for table purchase_request_note_status_type
-- ----------------------------
ALTER TABLE
    "public"."purchase_request_note_status_type"
ADD
    CONSTRAINT "purchase_request_note_status_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."purchase_request_note_status_type_id_seq" OWNED BY "public"."purchase_request_note_status_type"."id";

SELECT
    setval(
        '"public"."purchase_request_note_status_type_id_seq"',
        2,
        true
    );