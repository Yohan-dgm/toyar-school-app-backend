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
-- Sequence structure for supplier_bill_status_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."supplier_bill_status_type_id_seq";

CREATE SEQUENCE "public"."supplier_bill_status_type_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for supplier_bill_status_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."supplier_bill_status_type";

CREATE TABLE "public"."supplier_bill_status_type" (
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "sequential_order" int4,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval(
        'supplier_bill_status_type_id_seq' :: regclass
    )
);

-- ---------------------------
-- Records of supplier_bill_status_type
-- ----------------------------
INSERT INTO
    "public"."supplier_bill_status_type"
VALUES
    (
        'Receival Pending',
        1,
        1,
        NULL,
        '2024-11-12 16:49:46',
        NULL,
        1
    );

INSERT INTO
    "public"."supplier_bill_status_type"
VALUES
    (
        'Receival Complete',
        2,
        1,
        NULL,
        '2024-11-12 16:50:01',
        NULL,
        2
    );

INSERT INTO
    "public"."supplier_bill_status_type"
VALUES
    (
        'Canceled',
        3,
        1,
        NULL,
        '2024-11-12 16:50:01',
        NULL,
        3
    );

-- ----------------------------
-- Primary Key structure for table supplier_bill_status_type
-- ----------------------------
ALTER TABLE
    "public"."supplier_bill_status_type"
ADD
    CONSTRAINT "supplier_bill_status_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."supplier_bill_status_type_id_seq" OWNED BY "public"."supplier_bill_status_type"."id";

SELECT
    setval(
        '"public"."supplier_bill_status_type_id_seq"',
        3,
        true
    );