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

 Date: 09/12/2024 10:15:03
*/

-- ----------------------------
-- Sequence structure for person_title_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."person_title_id_seq";
CREATE SEQUENCE "public"."person_title_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for person_title
-- ----------------------------
DROP TABLE IF EXISTS "public"."person_title";
CREATE TABLE "public"."person_title" (
  "id" int8 NOT NULL DEFAULT nextval('person_title_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default", 
  "sequential_order" int8,
  "created_by" int8, 
  "updated_by" int8, 
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
)
;

-- ----------------------------
-- Records of person_title
-- ----------------------------
INSERT INTO "public"."person_title" VALUES (1, 'Mr.', 1, NULL, NULL); 
INSERT INTO "public"."person_title" VALUES (2, 'Ms..', 2, NULL, NULL); 
INSERT INTO "public"."person_title" VALUES (3, 'Mrs.', 3, NULL, NULL); 
INSERT INTO "public"."person_title" VALUES (4, 'Dr.', 4, NULL, NULL); 
INSERT INTO "public"."person_title" VALUES (5, 'Prof.', 5, NULL, NULL); 
INSERT INTO "public"."person_title" VALUES (6, 'Ven.', 6, NULL, NULL); 
INSERT INTO "public"."person_title" VALUES (7, 'Rev.', 7, NULL, NULL); 

-- ----------------------------
-- Primary Key structure for table person_title
-- ----------------------------
ALTER TABLE "public"."person_title" ADD CONSTRAINT "person_title_pkey" PRIMARY KEY ("id");


-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."person_title_id_seq"
OWNED BY "public"."person_title"."id";
SELECT setval('"public"."person_title_id_seq"', 7, true);



