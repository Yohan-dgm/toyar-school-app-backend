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
 
 Date: 09/12/2024 10:15:30
 */

-- ----------------------------
-- Sequence structure for sport_coaches_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."sport_coaches_id_seq";

CREATE SEQUENCE "public"."sport_coaches_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for sport_coaches
-- ----------------------------
DROP TABLE IF EXISTS "public"."sport_coaches";

CREATE TABLE "public"."sport_coaches" (
    "id" int8 NOT NULL DEFAULT nextval('sport_coaches_id_seq' :: regclass),
    "sport_id" int8 NOT NULL,
    "coach_id" int8 NOT NULL,
    "is_head_coach" bool DEFAULT false,
    "is_active" bool DEFAULT true,
    "started_date" date NOT NULL DEFAULT CURRENT_DATE,
    "ended_date" date,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table sport_coaches
-- ----------------------------
ALTER TABLE "public"."sport_coaches" 
ADD CONSTRAINT "sport_coaches_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes for performance
-- ----------------------------
CREATE INDEX "idx_sport_coaches_sport_id" ON "public"."sport_coaches" ("sport_id");
CREATE INDEX "idx_sport_coaches_coach_id" ON "public"."sport_coaches" ("coach_id");
CREATE INDEX "idx_sport_coaches_active" ON "public"."sport_coaches" ("is_active");

-- ----------------------------
-- Foreign Key Constraints
-- ----------------------------
-- Note: Foreign key constraints should be added based on your specific table relationships
-- ALTER TABLE "public"."sport_coaches" ADD CONSTRAINT "fk_sport_coaches_sport" FOREIGN KEY ("sport_id") REFERENCES "public"."sport" ("id");
-- ALTER TABLE "public"."sport_coaches" ADD CONSTRAINT "fk_sport_coaches_coach" FOREIGN KEY ("coach_id") REFERENCES "public"."educator" ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."sport_coaches_id_seq" OWNED BY "public"."sport_coaches"."id";

SELECT setval('"public"."sport_coaches_id_seq"', 1, false);