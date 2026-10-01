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
-- Sequence structure for educator_subject_pivot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."educator_subject_pivot_id_seq";

CREATE SEQUENCE "public"."educator_subject_pivot_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for educator_subject_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."educator_subject_pivot";

CREATE TABLE "public"."educator_subject_pivot" (
    "educator_id" int8 NOT NULL,
    "subject_id" int8 NOT NULL,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval(
        'educator_subject_pivot_id_seq' :: regclass
    )
);

-- ----------------------------
-- Records of educator_subject_pivot
-- ----------------------------
INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (12, 125, NULL, NULL, NULL, NULL, 1);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (12, 69, NULL, NULL, NULL, NULL, 2);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (11, 68, NULL, NULL, NULL, NULL, 3);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (14, 72, NULL, NULL, NULL, NULL, 4);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (14, 85, NULL, NULL, NULL, NULL, 5);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (14, 99, NULL, NULL, NULL, NULL, 6);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (16, 126, NULL, NULL, NULL, NULL, 26);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (16, 127, NULL, NULL, NULL, NULL, 27);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (16, 128, NULL, NULL, NULL, NULL, 28);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (18, 97, NULL, NULL, NULL, NULL, 29);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (18, 82, NULL, NULL, NULL, NULL, 30);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (18, 70, NULL, NULL, NULL, NULL, 31);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (10, 87, NULL, NULL, NULL, NULL, 32);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (10, 101, NULL, NULL, NULL, NULL, 33);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (10, 74, NULL, NULL, NULL, NULL, 34);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (9, 75, NULL, NULL, NULL, NULL, 35);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (9, 88, NULL, NULL, NULL, NULL, 36);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (9, 102, NULL, NULL, NULL, NULL, 38);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 76, NULL, NULL, NULL, NULL, 39);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 89, NULL, NULL, NULL, NULL, 40);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 103, NULL, NULL, NULL, NULL, 42);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 91, NULL, NULL, NULL, NULL, 43);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 78, NULL, NULL, NULL, NULL, 44);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (22, 81, NULL, NULL, NULL, NULL, 45);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (22, 95, NULL, NULL, NULL, NULL, 46);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (18, 108, NULL, NULL, NULL, NULL, 47);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (13, 105, NULL, NULL, NULL, NULL, 48);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (13, 112, NULL, NULL, NULL, NULL, 49);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (13, 119, NULL, NULL, NULL, NULL, 50);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (13, 123, NULL, NULL, NULL, NULL, 51);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (10, 129, NULL, NULL, NULL, NULL, 52);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (10, 130, NULL, NULL, NULL, NULL, 53);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (9, 131, NULL, NULL, NULL, NULL, 54);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (9, 132, NULL, NULL, NULL, NULL, 55);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 90, NULL, NULL, NULL, NULL, 56);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 110, NULL, NULL, NULL, NULL, 57);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (16, 133, NULL, NULL, NULL, NULL, 58);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (16, 134, NULL, NULL, NULL, NULL, 59);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (22, 107, NULL, NULL, NULL, NULL, 60);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (14, 109, NULL, NULL, NULL, NULL, 62);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (14, 116, NULL, NULL, NULL, NULL, 63);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (20, 115, NULL, NULL, NULL, NULL, 64);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (21, 104, NULL, NULL, NULL, NULL, 65);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (21, 111, NULL, NULL, NULL, NULL, 66);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (15, 1, NULL, NULL, NULL, NULL, 67);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (15, 10, NULL, NULL, NULL, NULL, 68);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (15, 5, NULL, NULL, NULL, NULL, 69);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (15, 6, NULL, NULL, NULL, NULL, 71);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (5, 18, NULL, NULL, NULL, NULL, 72);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (5, 14, NULL, NULL, NULL, NULL, 74);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (5, 19, NULL, NULL, NULL, NULL, 75);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (5, 17, NULL, NULL, NULL, NULL, 76);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (5, 23, NULL, NULL, NULL, NULL, 77);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (3, 31, NULL, NULL, NULL, NULL, 78);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (3, 27, NULL, NULL, NULL, NULL, 79);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (3, 30, NULL, NULL, NULL, NULL, 80);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (3, 32, NULL, NULL, NULL, NULL, 81);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (3, 36, NULL, NULL, NULL, NULL, 82);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (4, 40, NULL, NULL, NULL, NULL, 83);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (4, 41, NULL, NULL, NULL, NULL, 84);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (4, 45, NULL, NULL, NULL, NULL, 85);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (4, 49, NULL, NULL, NULL, NULL, 86);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (4, 44, NULL, NULL, NULL, NULL, 87);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (8, 3, NULL, NULL, NULL, NULL, 89);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (8, 16, NULL, NULL, NULL, NULL, 90);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (8, 29, NULL, NULL, NULL, NULL, 91);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (8, 43, NULL, NULL, NULL, NULL, 92);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (8, 55, NULL, NULL, NULL, NULL, 93);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (8, 54, NULL, NULL, NULL, NULL, 94);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (11, 42, NULL, NULL, NULL, NULL, 95);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (11, 28, NULL, NULL, NULL, NULL, 96);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (11, 15, NULL, NULL, NULL, NULL, 97);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (11, 2, NULL, NULL, NULL, NULL, 98);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (10, 9, NULL, NULL, NULL, NULL, 99);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (10, 22, NULL, NULL, NULL, NULL, 100);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (10, 35, NULL, NULL, NULL, NULL, 101);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (10, 48, NULL, NULL, NULL, NULL, 102);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (10, 61, NULL, NULL, NULL, NULL, 103);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 7, NULL, NULL, NULL, NULL, 104);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 20, NULL, NULL, NULL, NULL, 105);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 33, NULL, NULL, NULL, NULL, 106);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 46, NULL, NULL, NULL, NULL, 107);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (1, 77, NULL, NULL, NULL, NULL, 108);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (9, 8, NULL, NULL, NULL, NULL, 109);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (9, 21, NULL, NULL, NULL, NULL, 110);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (9, 34, NULL, NULL, NULL, NULL, 111);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (9, 47, NULL, NULL, NULL, NULL, 112);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (9, 60, NULL, NULL, NULL, NULL, 113);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (14, 12, NULL, NULL, NULL, NULL, 114);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (14, 25, NULL, NULL, NULL, NULL, 115);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (14, 38, NULL, NULL, NULL, NULL, 116);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (14, 51, NULL, NULL, NULL, NULL, 117);

INSERT INTO
    "public"."educator_subject_pivot"
VALUES
    (14, 64, NULL, NULL, NULL, NULL, 118);

-- ----------------------------
-- Primary Key structure for table educator_subject_pivot
-- ----------------------------
ALTER TABLE
    "public"."educator_subject_pivot"
ADD
    CONSTRAINT "educator_subject_pivot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."educator_subject_pivot_id_seq" OWNED BY "public"."educator_subject_pivot"."id";

SELECT
    setval(
        '"public"."educator_subject_pivot_id_seq"',
        118,
        true
    );