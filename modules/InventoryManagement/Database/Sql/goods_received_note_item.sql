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
-- Sequence structure for goods_received_note_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."goods_received_note_item_id_seq";

CREATE SEQUENCE "public"."goods_received_note_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for goods_received_note_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."goods_received_note_item";

CREATE TABLE "public"."goods_received_note_item" (
    "id" int8 NOT NULL DEFAULT nextval('goods_received_note_item_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "goods_received_note_id" int8,
    "purchase_order_id" int8,
    "purchase_order_item_id" int8,
    "ordered_quantity" numeric(15, 2),
    "item_unit" varchar(255) COLLATE "pg_catalog"."default",
    "received_quantity" numeric(15, 2),
    "received_by_id" int8,
    "shelf_life_start_date" date,
    "shelf_life_end_date" date,
    "is_goods_received_note_item_complete" bool
);

-- ---------------------------
-- Primary Key structure for table goods_received_note_item
-- ----------------------------
ALTER TABLE
    "public"."goods_received_note_item"
ADD
    CONSTRAINT "goods_received_note_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."goods_received_note_item_id_seq" OWNED BY "public"."goods_received_note_item"."id";

SELECT
    setval(
        '"public"."goods_received_note_item_id_seq"',
        1,
        false
    );