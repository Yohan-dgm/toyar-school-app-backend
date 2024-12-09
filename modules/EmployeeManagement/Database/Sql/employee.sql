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

 Date: 06/12/2024 15:57:21
*/
-- ----------------------------
-- Sequence structure for employee_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."employee_id_seq";
CREATE SEQUENCE "public"."employee_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;
-- ----------------------------
-- Table structure for employee
-- ----------------------------
DROP TABLE IF EXISTS "public"."employee";
CREATE TABLE "public"."employee" (
  "id" int8 NOT NULL DEFAULT nextval('employee_id_seq'::regclass),
  "full_name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "employee_type_id" int8 NOT NULL,
  "nic_number" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "epf_number" int8 NOT NULL,
  "remaining_annual_leaves" int8 NOT NULL,
  "remaining_medical_leaves" int8 NOT NULL,
  "remaining_maternity_leaves" int8 NOT NULL,
  "created_by" int8 NOT NULL,
  "updated_by" timestamp(0) NOT NULL
)
;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO "public"."employee" VALUES (1, 'Sevwandi Lanka Kankanamge', 3, '845103224V', 1, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (2, 'Wasala Tanthrige Noyeli Hansika Perera', 3, '200458210783', 2, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (3, 'Sirinayake Gunawardhanalage Niranja Hemali Gunawardhana', 3, '897420317V', 3, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (4, 'Kachchakaduge Nilanka Sajeewani Peiris', 3, '795015469V', 4, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (5, 'K K Tilki Subhashini De Alwis', 3, '856761304V', 5, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (6, 'Hewawasan Jayasooriyage Ruwan Nishantha Jayasooriya', 3, '197527301616', 6, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (7, 'Nawagamuwage Kalhari Ganga Perera', 3, '875770314V', 7, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (8, 'M.A Hiruni Sulochana Madhuwanthi', 3, '935531578V', 8, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (9, 'C.M.R Tharuka Sathsarani', 3, '985771170V', 9, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (10, 'K.M Nirosha Madushika Karunarathne', 3, '946193178V', 10, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (11, 'Nethmi Shehani Kasthuriarachchi', 3, '977752167V', 11, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (12, 'M R H Maheshi Meegalla', 3, '997653823V', 12, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (13, 'Dissanayake Mudiyanselage Upeksha Chethana Dissanayake', 3, '200169603890', 13, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (14, 'R Sithumi Bhagya Senevirathne', 3, '997132467 V', 14, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (15, 'M D Piyumika S Weerasinghe', 3, '995591812V', 15, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (16, 'Shavinke Nimesh Nicol Trimanne', 3, '', 16, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (17, 'Hasandi Nethmi Wickrmasooriya', 3, '200565804744', 17, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (18, 'Assarapullige Roshel Anjala De Silva', 3, '995882876V', 18, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (19, 'Shakila Anushki Wanigasinghe', 3, '907473392V', 9, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (20, 'Bodiyabaduge Roshenka Madhushani Fernando', 3, '987521970V', 20, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (21, 'Niyagama Pathiranage Okitma Sandanaki', 3, '200370110039', 0, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (22, 'W A Wathsala Madhubhasini ', 3, '', 0, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (23, 'R A Nethmi Nayanathara', 3, '', 0, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (24, 'Wanni Arachchige Saranga Iresh Fonseka', 3, '831471042V', 0, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (25, 'Athauda Arachchilage Chaminda Sisira Kumara Athauda Arachchi', 3, '', 0, 14, 7, 0, 0, '0001-01-01 00:00:00');
INSERT INTO "public"."employee" VALUES (26, 'V A Sameera Chathuranga', 3, '', 0, 14, 7, 0, 0, '0001-01-01 00:00:00');
 
-- ----------------------------
-- Primary Key structure for table employee
-- ----------------------------
ALTER TABLE "public"."employee" ADD CONSTRAINT "employee_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."employee_id_seq"
OWNED BY "public"."employee"."id";
SELECT setval('"public"."employee_id_seq"', 26, true);

