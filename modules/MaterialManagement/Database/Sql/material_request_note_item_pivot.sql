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
 
 Date: 09/12/2024 11:59:18
 */
-- ----------------------------
-- Sequence structure for material_request_note_item_pivot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."material_request_note_item_pivot_id_seq";

CREATE SEQUENCE "public"."material_request_note_item_pivot_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for material_request_note_item_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."material_request_note_item_pivot";

CREATE TABLE "public"."material_request_note_item_pivot" (
    "id" int8 NOT NULL DEFAULT nextval(
        'material_request_note_item_pivot_id_seq' :: regclass
    ),
    "material_request_note_id" int8,
    "material_item_id" int8,
    "quantity" numeric(15, 2),
    "is_available" int4,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table material_request_note_item_pivot
-- ----------------------------
ALTER TABLE
    "public"."material_request_note_item_pivot"
ADD
    CONSTRAINT "material_request_note_item_pivot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."material_request_note_item_pivot_id_seq" OWNED BY "public"."material_request_note_item_pivot"."id";

SELECT
    setval(
        '"public"."material_request_note_item_pivot_id_seq"',
        1,
        false
    );