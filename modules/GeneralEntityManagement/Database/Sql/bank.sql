/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v5
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 19/12/2024 11:01:39
 */
-- ----------------------------
-- Sequence structure for bank_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."bank_id_seq";

CREATE SEQUENCE "public"."bank_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for bank
-- ----------------------------
DROP TABLE IF EXISTS "public"."bank";

CREATE TABLE "public"."bank" (
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(6),
    "updated_at" timestamp(6),
    "id" int8 NOT NULL DEFAULT nextval('bank_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default"
);

-- ----------------------------
-- Records of bank
-- ----------------------------
INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 1, 'Amana Bank PLC');

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 2, 'Bank of Ceylon');

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 3, 'Bank of China Ltd');

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 4, 'Cargills Bank PLC');

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 5, 'Citibank, N.A.');

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        6,
        'Commercial Bank of Ceylon PLC'
    );

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        7,
        'Deutsche Bank AG, Colombo Branch'
    );

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 8, 'DFCC Bank PLC');

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 9, 'Habib Bank Ltd');

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        10,
        'Hatton National Bank PLC'
    );

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 11, 'Indian Bank');

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        12,
        'Indian Overseas Bank'
    );

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        13,
        'National Development Bank PLC'
    );

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        14,
        'Nations Trust Bank PLC'
    );

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 15, 'MCB Bank Ltd');

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        16,
        'Pan Asia Banking Corporation PLC'
    );

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 17, 'People''s Bank');

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 18, 'Public Bank Berhad');

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 19, 'Sampath Bank PLC');

INSERT INTO
    "public"."bank"
VALUES
    (NULL, NULL, NULL, NULL, 20, 'Seylan Bank PLC');

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        21,
        'Standard Chartered Bank'
    );

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        22,
        'State Bank of India'
    );

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        23,
        'The Hongkong & Shanghai Banking Corporation Ltd (HSBC)'
    );

INSERT INTO
    "public"."bank"
VALUES
    (
        NULL,
        NULL,
        NULL,
        NULL,
        24,
        'Union Bank of Colombo PLC'
    );

-- ----------------------------
-- Primary Key structure for table bank
-- ----------------------------
ALTER TABLE
    "public"."bank"
ADD
    CONSTRAINT "bank_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."bank_id_seq" OWNED BY "public"."bank"."id";

SELECT
    setval('"public"."bank_id_seq"', 24, true);