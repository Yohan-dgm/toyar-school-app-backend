/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 09/12/2024 11:59:18
 */
-- ----------------------------
-- Sequence structure for purchase_request_note_status_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."purchase_request_note_status_id_seq";

CREATE SEQUENCE "public"."purchase_request_note_status_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for purchase_request_note_status
-- ----------------------------
DROP TABLE IF EXISTS "public"."purchase_request_note_status";

CREATE TABLE "public"."purchase_request_note_status" (
    "id" int8 NOT NULL DEFAULT nextval(
        'purchase_request_note_status_id_seq' :: regclass
    ),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "purchase_request_note_id" int8,
    "purchase_request_note_status_type_id" int8,
    "notes" text COLLATE "pg_catalog"."default",
    "status_changed_by_id" int8,
    "is_active" bool
);

-- ----------------------------
-- Primary Key structure for table purchase_request_note_status
-- ----------------------------
ALTER TABLE
    "public"."purchase_request_note_status"
ADD
    CONSTRAINT "purchase_request_note_status_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."purchase_request_note_status_id_seq" OWNED BY "public"."purchase_request_note_status"."id";

SELECT
    setval(
        '"public"."purchase_request_note_status_id_seq"',
        1,
        false
    );