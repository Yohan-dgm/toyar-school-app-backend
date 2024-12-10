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

 Date: 10/12/2024 06:25:44
*/
-- ----------------------------
-- Sequence structure for student_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."student_id_seq";
CREATE SEQUENCE "public"."student_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS "public"."student";
CREATE TABLE "public"."student" (
  "id" int8 NOT NULL DEFAULT nextval('student_id_seq'::regclass),
  "applicant_id" int8 NOT NULL,
  "admission_number" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "student_admission_source_id" int8 NOT NULL,
  "joined_date" timestamp(0) NOT NULL,
  "full_name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "gender" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "full_name_with_title" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "date_of_birth" timestamp(0) NOT NULL,
  "nationality_id" int8 NOT NULL,
  "religion_id" int8 NOT NULL,
  "grade_level_id" int8 NOT NULL,
  "full_address" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "phone" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "school_studied_before" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "special_conditions" text COLLATE "pg_catalog"."default" NOT NULL,
  "admission_fee_discount_percentage" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "approved_admission_fee" numeric(10,1) NOT NULL,
  "applicable_refundable_deposit" numeric(10,1) NOT NULL,
  "applicable_term_payment" numeric(10,1) NOT NULL,
  "applicable_year_payment" numeric(10,1) NOT NULL,
  "created_by" int8 NOT NULL,
  "updated_by" int8 NOT NULL
);

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO "public"."student" VALUES (1, 0, 'NY24/001', 1, '2024-04-03 00:00:00', 'Sayul Sadiruth Wijerathne', '', '', '0001-01-01 00:00:00', 0, 0, 5, '', '', '', '', '', '1', 0.0, 0.0, 0.0, 0.0, 0, 0);
INSERT INTO "public"."student" VALUES (2, 0, 'NY24/002', 1, '2024-04-03 00:00:00', 'Vihani Sehansa Wijerathne', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '1', 0.0, 0.0, 0.0, 0.0, 0, 0);
INSERT INTO "public"."student" VALUES (3, 0, 'NY24/003', 1, '2024-04-03 00:00:00', 'Sehas Senurud Wijerathne', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '1', 0.0, 0.0, 0.0, 0.0, 0, 0);
INSERT INTO "public"."student" VALUES (4, 0, 'NY24/004', 2, '2024-03-11 00:00:00', 'Lumini Lisanga', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (5, 0, 'NY24/005', 2, '2024-03-22 00:00:00', 'Didula Damsara Rupasingha', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (6, 0, 'NY24/006', 2, '2024-03-31 00:00:00', 'Vidni Tiyasha Jayasinghe', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (7, 0, 'NY24/007', 3, '2024-04-01 00:00:00', 'Vihas Nishakkaya Hettikankanamlage', '', '', '0001-01-01 00:00:00', 0, 0, 3, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (8, 0, 'NY24/008', 3, '2024-04-01 00:00:00', 'Senul Yuhansa Liyanage', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0.5', 150000.0, 0.0, 35000.0, 140000.0, 0, 0);
INSERT INTO "public"."student" VALUES (9, 0, 'NY24/009', 1, '2024-04-03 00:00:00', 'Ayaan Nimneth', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 0.0, 0.0, 0, 0);
INSERT INTO "public"."student" VALUES (10, 0, 'NY24/010', 1, '2024-04-07 00:00:00', 'Maharu Abineth Abeyrathna', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0', 0.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (11, 0, 'NY24/011', 2, '2024-04-08 00:00:00', 'Sayuni Hiyansa Rathnayake', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (12, 0, 'NY24/012', 2, '2024-04-21 00:00:00', 'Kethmi Vithulya Kulathunga', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0.5', 150000.0, 0.0, 24000.0, 96000.0, 0, 0);
INSERT INTO "public"."student" VALUES (13, 0, 'NY24/013', 2, '2024-04-22 00:00:00', 'Vinudi Sehansa Dissanayake', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (14, 0, 'NY24/014', 2, '2024-04-28 00:00:00', 'Ayan Vindeew Hapugala', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (15, 0, 'NY24/015', 5, '2024-04-28 00:00:00', 'Thiven Ranyuga Dharmadasa', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0.5', 150000.0, 0.0, 35000.0, 140000.0, 0, 0);
INSERT INTO "public"."student" VALUES (16, 0, 'NY24/016', 2, '2024-04-28 00:00:00', 'Chanuga Abiru Kariyawasam', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (17, 0, 'NY24/019', 2, '2024-05-15 00:00:00', 'Vidya Rose', '', '', '0001-01-01 00:00:00', 0, 0, 4, '', '', '', '', '', '0.5', 150000.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (18, 0, 'NY24/020', 2, '2024-05-05 00:00:00', 'Yesandu Yesath Bandara Heenkenda', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (19, 0, 'NY24/021', 3, '2024-05-10 00:00:00', 'Minindu Yashvin Ranagala', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0.5', 150000.0, 50000.0, 35000.0, 140000.0, 0, 0);
INSERT INTO "public"."student" VALUES (20, 0, 'NY24/022', 9, '2024-05-13 00:00:00', 'Dihansa Randuli Mudannayaka', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (21, 0, 'NY24/023', 5, '2024-05-14 00:00:00', 'Kelly Yehansa Gamlath', '', '', '0001-01-01 00:00:00', 0, 0, 2, '', '', '', '', '', '0.5', 150000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (22, 0, 'NY24/024', 2, '2024-05-16 00:00:00', 'Minudi Chenaya Mudannayaka', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (23, 0, 'NY24/025', 10, '2024-05-17 00:00:00', 'Lahan Indiv Abeysiri', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0.5', 150000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (24, 0, 'NY24/026', 1, '2024-05-17 00:00:00', 'Dhanija Himansa Wanniarachchi', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (25, 0, 'NY24/027', 1, '2024-05-17 00:00:00', 'Mathisha Nemsara Wanniarachchi', '', '', '0001-01-01 00:00:00', 0, 0, 3, '', '', '', '', '', '0.5', 150000.0, 0.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (26, 0, 'NY24/028', 1, '2024-05-17 00:00:00', 'Savinu Hesan Wanniarachchi', '', '', '0001-01-01 00:00:00', 0, 0, 5, '', '', '', '', '', '1', 0.0, 0.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (27, 0, 'NY24/029', 6, '2024-05-17 00:00:00', 'Kenula Vidyaan Withanage', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', '0.5', 150000.0, 0.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (28, 0, 'NY24/030', 7, '2024-05-17 00:00:00', 'Lakindu Sehansa Senevirathna', '', '', '0001-01-01 00:00:00', 0, 0, 4, '', '', '', '', '', '0.5', 150000.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (29, 0, 'NY24/031', 7, '2024-05-17 00:00:00', 'Thidas Gaweshitha Dewarda', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0.5', 150000.0, 50000.0, 35000.0, 140000.0, 0, 0);
INSERT INTO "public"."student" VALUES (30, 0, 'NY24/032', 7, '2024-05-18 00:00:00', 'Mayoo Basara', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', '0.5', 150000.0, 0.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (31, 0, 'NY24/033', 9, '2024-05-19 00:00:00', 'Sanushi Nihelya Illangakoon', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0.5', 150000.0, 0.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (32, 0, 'NY24/034', 7, '2024-05-20 00:00:00', 'Tharushi Manulya', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (33, 0, 'NY24/035', 6, '2024-05-26 00:00:00', 'Dulina Thinal Dangalle', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (34, 0, 'NY24/036', 3, '2024-05-29 00:00:00', 'Sayon Thewsas', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (35, 0, 'NY24/037', 3, '2024-05-30 00:00:00', 'Vinudi Dewhari Fernando', '', '', '0001-01-01 00:00:00', 0, 0, 2, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (36, 0, 'NY24/038', 3, '2024-05-31 00:00:00', 'Dinuka Thiven Wijeratne', '', '', '0001-01-01 00:00:00', 0, 0, 3, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (37, 0, 'NY24/039', 5, '2024-06-10 00:00:00', 'Dishen Minhas Wijayarathne', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', '0.25', 225000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (38, 0, 'NY24/040', 7, '2024-06-14 00:00:00', 'Thenul Minidinu Jayawardena', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0.25', 225000.0, 0.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (39, 0, 'NY24/041', 1, '2024-06-22 00:00:00', 'Linaya Dewlini Atapattu', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (40, 0, 'NY24/042', 10, '2024-06-25 00:00:00', 'Kemie Oleena Hewawasam', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', 'Only EY', 50000.0, 0.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (41, 0, 'NY24/043', 7, '2024-06-25 00:00:00', 'Senumi Pehansa Edirisingha', '', '', '0001-01-01 00:00:00', 0, 0, 5, '', '', '', '', '', '0.25', 225000.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (42, 0, 'NY24/044', 1, '2024-06-25 00:00:00', 'Senara Randaya Waduwalage', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (43, 0, 'NY24/045', 6, '2024-06-27 00:00:00', 'Senithu Sethnula Manchanayaka', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', '0.25', 225000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (44, 0, 'NY24/046', 1, '2024-06-28 00:00:00', 'Indusha Nirmith Sandaruwan', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (45, 0, 'NY24/047', 6, '2024-06-28 00:00:00', 'Minew Dehas Madampagama', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', '0.25', 225000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (46, 0, 'NY24/048', 1, '2024-06-29 00:00:00', 'Senulya Arunadee', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (47, 0, 'NY24/049', 1, '2024-06-30 00:00:00', 'Thinuka Hathurusingha', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (48, 0, 'NY24/050', 1, '2024-07-01 00:00:00', 'Theuni Thathsarani Perera', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (49, 0, 'NY24/051', 1, '2024-07-08 00:00:00', 'Danara Methsandi', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (50, 0, 'NY24/052', 1, '2024-07-08 00:00:00', 'Dinuthi Sesanga', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (51, 0, 'NY24/053', 1, '2024-07-08 00:00:00', 'Dimantha Weragoda', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (52, 0, 'NY24/054', 8, '2024-07-08 00:00:00', 'Danuka Kithvin Bandara Harangala', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (53, 0, 'NY24/055', 8, '2024-07-08 00:00:00', 'Vithun Sechitha Manathunga', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (54, 0, 'NY24/056', 3, '2024-07-10 00:00:00', 'Ehansa Harasarani', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (55, 0, 'NY24/057', 7, '2024-07-11 00:00:00', 'Yoshika Naveen Jaweera', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (56, 0, 'NY24/058', 8, '2024-07-12 00:00:00', 'Anuhas Vihanga Jayasekara', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (57, 0, 'NY24/059', 5, '2024-07-12 00:00:00', 'Vihari Lavanya Rathnayaka', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (58, 0, 'NY24/060', 8, '2024-07-14 00:00:00', 'Thesath Dewmina Ranweera', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (59, 0, 'NY24/061', 2, '2024-07-15 00:00:00', 'Yenudi Venulya Jayalath', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0', 0.0, 0.0, 20000.0, 80000.0, 0, 0);
INSERT INTO "public"."student" VALUES (60, 0, 'NY24/062', 2, '2024-07-15 00:00:00', 'Sandathi Sahasna Jayarathna', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0', 0.0, 0.0, 24000.0, 96000.0, 0, 0);
INSERT INTO "public"."student" VALUES (61, 0, 'NY24/063', 2, '2024-07-15 00:00:00', 'Yuvin Thevjan', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0', 0.0, 0.0, 24000.0, 96000.0, 0, 0);
INSERT INTO "public"."student" VALUES (62, 0, 'NY24/064', 2, '2024-07-15 00:00:00', 'Sahasnee Sanalya Senanayake', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0', 0.0, 0.0, 20000.0, 80000.0, 0, 0);
INSERT INTO "public"."student" VALUES (63, 0, 'NY24/066', 5, '2024-07-15 00:00:00', 'Shayara Haili Nawararthna', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0.5', 150000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (64, 0, 'NY24/067', 8, '2024-07-16 00:00:00', 'Sihina Dushangana Herath', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (65, 0, 'NY24/068', 2, '2024-07-15 00:00:00', 'Thinara Dahamsi Rajapaksha', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0', 0.0, 0.0, 24000.0, 96000.0, 0, 0);
INSERT INTO "public"."student" VALUES (66, 0, 'NY24/069', 2, '2024-07-15 00:00:00', 'Himandee Bihara Rathnayaka', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0', 0.0, 0.0, 24000.0, 96000.0, 0, 0);
INSERT INTO "public"."student" VALUES (67, 0, 'NY24/071', 2, '2024-07-15 00:00:00', 'Ramiru Dihein Ranathunge', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0', 0.0, 0.0, 24000.0, 96000.0, 0, 0);
INSERT INTO "public"."student" VALUES (68, 0, 'NY24/072', 2, '2024-07-15 00:00:00', 'Sihina Anuhas Dahanayake', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0', 0.0, 0.0, 12000.0, 48000.0, 0, 0);
INSERT INTO "public"."student" VALUES (69, 0, 'NY24/074', 2, '2024-07-15 00:00:00', 'Sadil Damnath Siriwardena', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0', 0.0, 0.0, 24000.0, 96000.0, 0, 0);
INSERT INTO "public"."student" VALUES (70, 0, 'NY24/075', 2, '2024-07-15 00:00:00', 'Ruhan Nimesh Siyambalapitiya', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0', 0.0, 0.0, 20000.0, 80000.0, 0, 0);
INSERT INTO "public"."student" VALUES (71, 0, 'NY24/077', 8, '2024-07-16 00:00:00', 'Senitha Dinod Ranathunga', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (72, 0, 'NY24/078', 2, '2024-07-16 00:00:00', 'Sahas Winsara Bandara', '', '', '0001-01-01 00:00:00', 0, 0, 6, '', '', '', '', '', '0.5', 150000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (73, 0, 'NY24/079', 8, '2024-07-11 00:00:00', 'Mohamed Raashid Fareed', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (74, 0, 'NY24/080', 2, '2024-07-18 00:00:00', 'Withakshana Dewkith Dissanayaka', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0', 0.0, 0.0, 24000.0, 96000.0, 0, 0);
INSERT INTO "public"."student" VALUES (75, 0, 'NY24/081', 2, '2024-07-18 00:00:00', 'Kithnuli Vethaka Hapanagama', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0', 0.0, 0.0, 24000.0, 96000.0, 0, 0);
INSERT INTO "public"."student" VALUES (76, 0, 'NY24/082', 9, '2024-07-19 00:00:00', 'Esindu Sharinya', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (77, 0, 'NY24/083', 3, '2024-07-19 00:00:00', 'Enoli Adeena', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', '0.25', 225000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (78, 0, 'NY24/084', 2, '2024-07-17 00:00:00', 'Inuki Aradhya Dissanayaka', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (79, 0, 'NY24/085', 5, '2024-07-19 00:00:00', 'Thiyon Sayul', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (80, 0, 'NY24/086', 8, '2024-07-21 00:00:00', 'Oneth Bonuka Athukorala', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (81, 0, 'NY24/087', 8, '2024-07-21 00:00:00', 'Sarah Dewmi Phillips', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (82, 0, 'NY24/088', 7, '2024-07-22 00:00:00', 'Nuvidi Liasha Jayathilaka', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', 'Only EY', 50000.0, 0.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (83, 0, 'NY24/089', 10, '2024-07-23 00:00:00', 'Emma Liyana Athauda', '', '', '0001-01-01 00:00:00', 0, 0, 2, '', '', '', '', '', '0.5', 150000.0, 50000.0, 0.0, 0.0, 0, 0);
INSERT INTO "public"."student" VALUES (84, 0, 'NY24/090', 3, '2024-07-23 00:00:00', 'Terash Shehansha Jayasekara', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (85, 0, 'NY24/091', 8, '2024-07-23 00:00:00', 'Chareen Dulneth Nissanka', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (86, 0, 'NY24/092', 2, '2024-07-24 00:00:00', 'Osindu Nethmina Jayarathna', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (87, 0, 'NY24/093', 8, '2024-07-24 00:00:00', 'Sahas Dewmin Sadeesha Widanage', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (88, 0, 'NY24/094', 8, '2024-07-24 00:00:00', 'Sayumdi Shakya Widanage', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (89, 0, 'NY24/095', 8, '2024-07-25 00:00:00', 'Yomith Devram Jayasooriya', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (90, 0, 'NY24/096', 8, '2024-07-26 00:00:00', 'Janiru Dulwan Herath', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (91, 0, 'NY24/099', 2, '2024-07-31 00:00:00', 'Lagni Akelya', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (92, 0, 'NY24/100', 8, '2024-07-31 00:00:00', 'Vimethka Ashinshani Heiyanthuduwa', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (93, 0, 'NY24/101', 8, '2024-08-01 00:00:00', 'Manawa Siddhantha Rathnayaka', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (94, 0, 'NY24/102', 8, '2024-08-02 00:00:00', 'Adithya Damsara', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (95, 0, 'NY24/103', 8, '2024-08-03 00:00:00', 'Astrid Rees Wilson', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (96, 0, 'NY24/104', 8, '2024-08-03 00:00:00', 'Zainab Ammaaraah Fareed', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (97, 0, 'NY24/105', 8, '2024-08-03 00:00:00', 'Sesath Randinu Jayasuriya', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (98, 0, 'NY24/106', 8, '2024-08-04 00:00:00', 'Changa Banu Bandara', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (99, 0, 'NY24/107', 3, '2024-08-05 00:00:00', 'Hana Akelya Mavella', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', 'Only EY', 50000.0, 0.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (100, 0, 'NY24/108', 8, '2024-08-05 00:00:00', 'Lisanda Mindula Samarakoon', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (101, 0, 'NY24/109', 1, '2024-08-06 00:00:00', 'Abinu Nissanka', '', '', '0001-01-01 00:00:00', 0, 0, 3, '', '', '', '', '', '0', 300000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (102, 0, 'NY24/110', 8, '2024-08-06 00:00:00', 'Dinath Demitha', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (103, 0, 'NY24/111', 8, '2024-08-06 00:00:00', 'Menuk Methmitha', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (104, 0, 'NY24/112', 8, '2024-08-06 00:00:00', 'Sadew Lochana Jayasinghe', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (105, 0, 'NY24/113', 8, '2024-08-06 00:00:00', 'Sithuli Sidangana Jayasinghe', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (106, 0, 'NY24/114', 8, '2024-07-06 00:00:00', 'Isogai Takeru', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (107, 0, 'NY24/115', 8, '2024-07-06 00:00:00', 'Isogai Yutaka', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (108, 0, 'NY24/116', 8, '2024-07-06 00:00:00', 'Saheli Sethumini Samarakoon', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (109, 0, 'NY24/117', 1, '2024-08-07 00:00:00', 'Chanul Yaneth Wijesinghe', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (110, 0, 'NY24/118', 8, '2024-08-06 00:00:00', 'Sanuka Nimnada Perera', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (111, 0, 'NY24/119', 8, '2024-08-06 00:00:00', 'Senuki Hiyansa Perera', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (112, 0, 'NY24/120', 8, '2024-08-06 00:00:00', 'Dulen Uthmika Rupasena', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (113, 0, 'NY24/121', 8, '2024-08-06 00:00:00', 'Chamidu Jehan Senarath', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (114, 0, 'NY24/122', 5, '2024-08-06 00:00:00', 'Sheyon Ushel', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0.5', 150000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (115, 0, 'NY24/123', 8, '2024-08-07 00:00:00', 'Miheli Ranulya', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (116, 0, 'NY24/124', 8, '2024-08-07 00:00:00', 'Hiruki Senara Mudannayake', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (117, 0, 'NY24/125', 2, '2024-08-08 00:00:00', 'Sanarah Anne Philips', '', '', '0001-01-01 00:00:00', 0, 0, 4, '', '', '', '', '', '0.5', 150000.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (118, 0, 'NY24/126', 5, '2024-08-08 00:00:00', 'Esandi Onaaya', '', '', '0001-01-01 00:00:00', 0, 0, 2, '', '', '', '', '', '0', 300000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (119, 0, 'NY24/127', 2, '2024-08-08 00:00:00', 'Theviru Thihasmika Gamlath', '', '', '0001-01-01 00:00:00', 0, 0, 2, '', '', '', '', '', '0.5', 150000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (120, 0, 'NY24/128', 8, '2024-08-08 00:00:00', 'Praharshi Wirarathna', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (121, 0, 'NY24/129', 8, '2024-08-08 00:00:00', 'Rasandu Dilakshana', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (122, 0, 'NY24/130', 8, '2024-08-09 00:00:00', 'Tharusha Jayashanka', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (123, 0, 'NY24/131', 8, '2024-08-09 00:00:00', 'Janith Jayashanka', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (124, 0, 'NY24/132', 8, '2024-08-10 00:00:00', 'Adha Sara', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (125, 0, 'NY24/133', 8, '2024-08-10 00:00:00', 'Ahla Seema', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (126, 0, 'NY24/134', 10, '2024-08-10 00:00:00', 'Aayu Ishnika Rajasekara', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', 'Only EY', 50000.0, 0.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (127, 0, 'NY24/135', 8, '2024-08-10 00:00:00', 'Mesandu Mandil', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (128, 0, 'NY24/136', 8, '2024-08-10 00:00:00', 'Inudi Dulsandi Wijerathna', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (129, 0, 'NY24/137', 8, '2024-08-10 00:00:00', 'Rashmika Nisal Kavinda', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (130, 0, 'NY24/138', 8, '2024-08-10 00:00:00', 'Akein Dinsara', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (131, 0, 'NY24/139', 8, '2024-08-10 00:00:00', 'Chamika Anuhas Kaushalya', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (132, 0, 'NY24/140', 1, '2024-08-10 00:00:00', 'Dewdi Sedamsa Hingert', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0', 0.0, 0.0, 0.0, 0.0, 0, 0);
INSERT INTO "public"."student" VALUES (133, 0, 'NY24/143', 8, '2024-08-10 00:00:00', 'Tharini Bashika', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (134, 0, 'NY24/144', 8, '2024-08-10 00:00:00', 'Oshan Devinda', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (135, 0, 'NY24/145', 8, '2024-08-11 00:00:00', 'Rahal Maithri Weerathna', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (136, 0, 'NY24/146', 8, '2024-08-11 00:00:00', 'Sanuka Siyasara', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (137, 0, 'NY24/147', 8, '2024-08-12 00:00:00', 'Sadev Dulmeth Nissanka', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (138, 0, 'NY24/148', 8, '2024-08-12 00:00:00', 'Sanaya Mandini Nissanka', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (139, 0, 'NY24/149', 8, '2024-08-12 00:00:00', 'Amavi Nethaya Nissanka', '', '', '0001-01-01 00:00:00', 0, 0, 4, '', '', '', '', '', '0', 0.0, 0.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (140, 0, 'NY24/152', 10, '2024-08-12 00:00:00', 'Sidhuli Abheemanthra', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', 'Only EY', 50000.0, 0.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (141, 0, 'NY24/153', 8, '2024-08-12 00:00:00', 'Lakvidu Randul Samarakoon', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (142, 0, 'NY24/154', 8, '2024-08-12 00:00:00', 'Loshitha Maduranga', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (143, 0, 'NY24/155', 8, '2024-08-12 00:00:00', 'Videw Hansitha Chamiru Kuruppuarachchi', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (144, 0, 'NY24/156', 8, '2024-08-12 00:00:00', 'Hirusha Nimsara Kumarapeli', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (145, 0, 'NY24/157', 3, '2024-08-12 00:00:00', 'Erina Abhimani', '', '', '0001-01-01 00:00:00', 0, 0, 4, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (146, 0, 'NY24/158', 8, '2024-08-12 00:00:00', 'Methuka Sansana', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (147, 0, 'NY24/159', 8, '2024-08-12 00:00:00', 'Sethuka Hansana', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (148, 0, 'NY24/160', 8, '2024-08-13 00:00:00', 'Mithara Sayumdee Pattiwila', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (149, 0, 'NY24/161', 8, '2024-08-13 00:00:00', 'Avril Deluni Silva', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (150, 0, 'NY24/162', 10, '2024-08-13 00:00:00', 'Chenuka Sanjana Nugawela Weerasekara', '', '', '0001-01-01 00:00:00', 0, 0, 4, '', '', '', '', '', '0.25', 225000.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (151, 0, 'NY24/163', 8, '2024-08-13 00:00:00', 'Kenol Hesuka Adhikari', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (152, 0, 'NY24/164', 8, '2024-08-13 00:00:00', 'Hesara Onidi Mahanama', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (153, 0, 'NY24/165', 8, '2024-08-13 00:00:00', 'Sanija Mahanama', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (154, 0, 'NY24/166', 8, '2024-08-13 00:00:00', 'Thenuli Uthara Pathirana', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (155, 0, 'NY24/167', 8, '2024-08-13 00:00:00', 'Minul Dilain Wijayakoon', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (156, 0, 'NY24/168', 8, '2024-08-13 00:00:00', 'Yumara Sandaruvi Ranasinghe', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (157, 0, 'NY24/169', 8, '2024-08-13 00:00:00', 'Sanul Thidasindu Ranasinghe', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (158, 0, 'NY24/170', 8, '2024-08-13 00:00:00', 'Mayon Minketh Liyana Pathirana', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (159, 0, 'NY24/171', 9, '2024-08-13 00:00:00', 'Nuheli Ranulya Rupananda', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', 'Only Ey', 50000.0, 0.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (160, 0, 'NY24/172', 8, '2024-08-13 00:00:00', 'Senodyaa Thisendee Wijethunga', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0.25', 225000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (161, 0, 'NY24/173', 8, '2024-08-13 00:00:00', 'Senaayaa Thishen Senaruth Wijethunga', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (162, 0, 'NY24/174', 2, '2024-08-13 00:00:00', 'Senaayaa Thisumlee Wijethunga', '', '', '0001-01-01 00:00:00', 0, 0, 2, '', '', '', '', '', '0.5', 150000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (163, 0, 'NY24/175', 8, '2024-08-14 00:00:00', 'Anjula Maheesha Dedigama', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (164, 0, 'NY24/176', 8, '2024-08-14 00:00:00', 'Chamod Chirantha Nayana Sri Sooriyage', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (165, 0, 'NY24/177', 8, '2024-08-14 00:00:00', 'Pansilu Bimsara Menuja', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (166, 0, 'NY24/178', 8, '2024-08-14 00:00:00', 'Daniru Thenuka Kuruppu', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (167, 0, 'NY24/179', 8, '2024-08-14 00:00:00', 'Janith Bimsara Aluthge', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (168, 0, 'NY24/180', 8, '2024-08-14 00:00:00', 'Onitha Ranmeth', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (169, 0, 'NY24/181', 8, '2024-08-14 00:00:00', 'Nethumi Nulara Ranathunga', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (170, 0, 'NY24/182', 8, '2024-08-14 00:00:00', 'Chavindu Himansa Gunawardhana', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 49950.0, 199800.0, 0, 0);
INSERT INTO "public"."student" VALUES (171, 0, 'NY24/183', 8, '2024-08-14 00:00:00', 'Pujana Seneth Bandara Ekanayake', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (172, 0, 'NY24/184', 2, '2024-08-14 00:00:00', 'Ruwandi Tharunadee Menike Ekanayake', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0.25', 225000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (173, 0, 'NY24/185', 8, '2024-08-14 00:00:00', 'Thiseni Yuthara Kularathne', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (174, 0, 'NY24/186', 2, '2024-08-14 00:00:00', 'Shanaya Harumi Randhara Liyanage', '', '', '0001-01-01 00:00:00', 0, 0, 5, '', '', '', '', '', '0.5', 150000.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (175, 0, 'NY24/187', 1, '2024-08-14 00:00:00', 'Venusha Dehan Menuk Liyanage', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0.25', 225000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (176, 0, 'NY24/188', 8, '2024-08-14 00:00:00', 'Chandupa Mandara Suriyaarachchi', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (177, 0, 'NY24/189', 8, '2024-08-14 00:00:00', 'Shenal Vihansa Liyanage', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (178, 0, 'NY24/190', 1, '2024-08-14 00:00:00', 'Sehansa Geeganage', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (179, 0, 'NY24/191', 8, '2024-08-14 00:00:00', 'Manuja Vihas Rangajeewa', '', '', '0001-01-01 00:00:00', 0, 0, 6, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (180, 0, 'NY24/192', 8, '2024-08-14 00:00:00', 'Manuja Thehas Ragajeewa', '', '', '0001-01-01 00:00:00', 0, 0, 6, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (181, 0, 'NY24/193', 8, '2024-08-14 00:00:00', 'Senuki Thiyansa Dissanayake', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (182, 0, 'NY24/194', 8, '2024-08-14 00:00:00', 'Sadheesha Sahanmi Gunarathne', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (183, 0, 'NY24/195', 8, '2024-08-15 00:00:00', 'Vidas Thathsilu Bandara Samarakoon', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (184, 0, 'NY24/198', 8, '2024-08-15 00:00:00', 'Sehandi Nuhansa', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (185, 0, 'NY24/199', 8, '2024-08-15 00:00:00', 'Vihangi Senulya Akshari', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (186, 0, 'NY24/200', 8, '2024-08-15 00:00:00', 'Sethika Sithum Fernando', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (187, 0, 'NY24/201', 8, '2024-08-15 00:00:00', 'Sanuth Thenujaya Amarasingha', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (188, 0, 'NY24/202', 8, '2024-08-15 00:00:00', 'Senuka Sachin Mahage', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (189, 0, 'NY24/203', 8, '2024-08-15 00:00:00', 'Omandi Tashiya Devapura', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (190, 0, 'NY24/205', 8, '2024-08-15 00:00:00', 'Suvini Saubhagya', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (191, 0, 'NY24/206', 8, '2024-08-15 00:00:00', 'Asel Uthpala', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (192, 0, 'NY24/207', 8, '2024-08-15 00:00:00', 'Vinuli Suhansa Peiris', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (193, 0, 'NY24/208', 8, '2024-08-15 00:00:00', 'Vihas Senuja Pieris', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (194, 0, 'NY24/209', 8, '2024-08-15 00:00:00', 'Deshan Devkith Thathsara', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (195, 0, 'NY24/210', 10, '2024-08-16 00:00:00', 'Themindu Abhilash Sooriyabandara', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (196, 0, 'NY24/211', 10, '2024-08-20 00:00:00', 'Thamudi Shanaya', '', '', '0001-01-01 00:00:00', 0, 0, 2, '', '', '', '', '', '0.5', 50000.0, 50000.0, 20000.0, 80000.0, 0, 0);
INSERT INTO "public"."student" VALUES (197, 0, 'NY24/212', 9, '2024-08-17 00:00:00', 'Sathnara Methsathini', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (198, 0, 'NY24/213', 8, '2024-08-14 00:00:00', 'Deenu Minduli Suraweera De Silva', '', '', '0001-01-01 00:00:00', 0, 0, 7, '', '', '', '', '', '0', 0.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (199, 0, 'NY24/214', 8, '2024-08-21 00:00:00', 'Honal Lindul Jayatissa', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (200, 0, 'NY24/215', 8, '2024-08-21 00:00:00', 'Imira Sithlaka Adikari', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (201, 0, 'NY24/216', 2, '2024-08-22 00:00:00', 'Tehara Daffodil Wijesooriya', '', '', '0001-01-01 00:00:00', 0, 0, 5, '', '', '', '', '', '0.5', 150000.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (202, 0, 'NY24/217', 8, '2024-08-22 00:00:00', 'Imira Chamadith', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (203, 0, 'NY24/218', 2, '2024-08-23 00:00:00', 'Kusal Bimsara Dissanayake', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (204, 0, 'NY24/219', 3, '2024-08-25 00:00:00', 'Iyana Trifiny Samarajeewa', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (205, 0, 'NY24/220', 1, '2024-08-24 00:00:00', 'Denura Chamdith Gunathilaka', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (206, 0, 'NY24/221', 8, '2024-08-15 00:00:00', 'Chanul Nimthaka Amunegedara', '', '', '0001-01-01 00:00:00', 0, 0, 12, '', '', '', '', '', '0', 0.0, 0.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (207, 0, 'NY24/222', 1, '2024-08-15 00:00:00', 'Sinidi Bollagala', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (208, 0, 'NY24/223', 1, '2024-08-26 00:00:00', 'Sandaru Dineth Dunuthilaka', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (209, 0, 'NY24/224', 1, '2024-08-26 00:00:00', 'Gayuki Tharulya Mirihagalla', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', '0.25', 225000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (210, 0, 'NY24/225', 1, '2024-08-27 00:00:00', 'Pasan Perera', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (211, 0, 'NY24/226', 1, '2024-08-28 00:00:00', 'Hiruki Kisakya Wijayasinghe', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0.5', 150000.0, 0.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (212, 0, 'NY24/227', 1, '2024-08-28 00:00:00', 'Shalini Hiranya Kolonne', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (213, 0, 'NY24/228', 2, '2024-08-28 00:00:00', 'Shenuka Wishwantha Kolonne', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0.25', 225000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (214, 0, 'NY24/229', 1, '2024-08-28 00:00:00', 'Dinushi Pramodya Samarakoon', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (215, 0, 'NY24/230', 10, '2024-08-28 00:00:00', 'Daniru Sanmeth Ambegoda', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (216, 0, 'NY24/231', 1, '2024-08-28 00:00:00', 'Aken Nimsuka Ranasinghe', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (217, 0, 'NY24/232', 2, '2024-08-29 00:00:00', 'Aayu Vishvadinu Illangarathna', '', '', '0001-01-01 00:00:00', 0, 0, 2, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (218, 0, 'NY24/233', 9, '2024-08-30 00:00:00', 'Kavimina Sadew', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 35000.0, 140000.0, 0, 0);
INSERT INTO "public"."student" VALUES (219, 0, 'NY24/234', 9, '2024-08-30 00:00:00', 'Sanith Yugan Jayasundara', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (220, 0, 'NY24/235', 1, '2024-08-31 00:00:00', 'Desindu Chamikara Rathnaweera', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (221, 0, 'NY24/236', 1, '2024-09-01 00:00:00', 'Binuk Yethmika', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (222, 0, 'NY24/237', 10, '2024-09-02 00:00:00', 'Methmika Wijewardena', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', '0.5', 25000.0, 50000.0, 12500.0, 50000.0, 0, 0);
INSERT INTO "public"."student" VALUES (223, 0, 'NY24/238', 2, '2024-09-01 00:00:00', 'Jevindu Imeth', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0.5', 150000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (224, 0, 'NY24/239', 10, '2024-09-05 00:00:00', 'Oviru Vinuwara Ranasinghe', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (225, 0, 'NY24/240', 7, '2024-09-06 00:00:00', 'Zero Senaji', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0', 300000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (226, 0, 'NY24/241', 2, '2024-09-06 00:00:00', 'Sandil Hirunaka', '', '', '0001-01-01 00:00:00', 0, 0, 9, '', '', '', '', '', '0', 300000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (227, 0, 'NY24/242', 2, '2024-09-06 00:00:00', 'Sejan Thevnaka', '', '', '0001-01-01 00:00:00', 0, 0, 6, '', '', '', '', '', '0.5', 150000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (228, 0, 'NY24/243', 2, '2024-09-06 00:00:00', 'Mihindi Methyumee', '', '', '0001-01-01 00:00:00', 0, 0, 4, '', '', '', '', '', '1', 0.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (229, 0, 'NY24/244', 1, '2024-09-07 00:00:00', 'Rivitha Nethdula Wijesinghe', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0', 300000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (230, 0, 'NY24/245', 10, '2024-09-07 00:00:00', 'Umaya Mandari Arangalla', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 300000.0, 50000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (231, 0, 'NY24/246', 1, '2024-09-10 00:00:00', 'Tashima Mayumi Athukorala', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 300000.0, 50000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (232, 0, 'NY24/247', 10, '2024-09-11 00:00:00', 'Senula Sasmitha', '', '', '0001-01-01 00:00:00', 0, 0, 6, '', '', '', '', '', '0', 300000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (233, 0, 'NY24/248', 9, '2024-09-12 00:00:00', 'Senara Withumili', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (234, 0, 'NY24/249', 9, '2024-09-13 00:00:00', 'Rashiv Adrian Jayasinghe', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (235, 0, 'NY24/250', 1, '2024-09-15 00:00:00', 'Senila Disas Randilu Weerakoon', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0.5', 150000.0, 50000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (236, 0, 'NY24/251', 8, '2024-09-20 00:00:00', 'Hashen Randika Rodrigo', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 0.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (237, 0, 'NY24/252', 10, '2024-09-23 00:00:00', 'Ravija Ranuraka Pelenda', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 300000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (238, 0, 'NY24/253', 8, '2024-09-26 00:00:00', 'Manuka Sawain ', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 300000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (239, 0, 'NY24/254', 1, '2024-09-26 00:00:00', 'Binu Waragana', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (240, 0, 'NY24/255', 1, '2024-09-26 00:00:00', 'Tinuki Sehansa', '', '', '0001-01-01 00:00:00', 0, 0, 2, '', '', '', '', '', '0.5', 150000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (241, 0, 'NY24/256', 3, '2024-09-27 00:00:00', 'Kayili Eleena', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (242, 0, 'NY24/257', 9, '2024-09-30 00:00:00', 'Amani Ithara', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (243, 0, 'NY24/258', 9, '2024-10-03 00:00:00', 'Arya Menuki Gunasoma', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', 'Only EY', 50000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (244, 0, 'NY24/259', 1, '2024-10-05 00:00:00', 'Nisika Dulmeth Perera', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 300000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (245, 0, 'NY24/260', 8, '2024-10-07 00:00:00', 'Vithum Methsilu Warnakula', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', 'Free', 0.0, 0.0, 0.0, 0.0, 0, 0);
INSERT INTO "public"."student" VALUES (246, 0, 'NY24/261', 1, '2024-10-11 00:00:00', 'Shiyon Menosh ', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.25', 225000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (247, 0, 'NY24/262', 1, '2024-10-14 00:00:00', 'Venuja Nethmira', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (248, 0, 'NY24/263', 1, '2024-10-14 00:00:00', 'Sandali Damsini', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (249, 0, 'NY24/264', 1, '2024-10-14 00:00:00', 'Thisum Anuhas Gunasinghe', '', '', '0001-01-01 00:00:00', 0, 0, 11, '', '', '', '', '', '0', 0.0, 100000.0, 50000.0, 200000.0, 0, 0);
INSERT INTO "public"."student" VALUES (250, 0, 'NY24/265', 9, '2024-10-05 00:00:00', 'Pruthuwi Sithum', '', '', '0001-01-01 00:00:00', 0, 0, 8, '', '', '', '', '', '0', 300000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (251, 0, 'NY24/266', 9, '2024-10-21 00:00:00', 'Nithila Newan', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', 'only EY', 50000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (252, 0, 'NY24/267', 2, '2024-10-26 00:00:00', 'Kithnuli Vethumya', '', '', '0001-01-01 00:00:00', 0, 0, 13, '', '', '', '', '', 'Only Ey', 50000.0, 50000.0, 25000.0, 100000.0, 0, 0);
INSERT INTO "public"."student" VALUES (253, 0, 'NY24/268', 7, '2024-10-25 00:00:00', 'Minulya Bodhinayaka', '', '', '0001-01-01 00:00:00', 0, 0, 5, '', '', '', '', '', '0', 300000.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (254, 0, 'NY24/269', 7, '2024-10-25 00:00:00', 'Vihan Bodhinayaka', '', '', '0001-01-01 00:00:00', 0, 0, 15, '', '', '', '', '', '0.5', 150000.0, 50000.0, 35000.0, 140000.0, 0, 0);
INSERT INTO "public"."student" VALUES (255, 0, 'NY24/271', 3, '2024-11-04 00:00:00', 'Sanaya Nisini Kodithuwakku', '', '', '0001-01-01 00:00:00', 0, 0, 4, '', '', '', '', '', '0', 300000.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (256, 0, 'NY24/272', 5, '2024-11-05 00:00:00', 'Sasiru Bonuka Mandiapperuma', '', '', '0001-01-01 00:00:00', 0, 0, 5, '', '', '', '', '', '0', 300000.0, 50000.0, 45000.0, 180000.0, 0, 0);
INSERT INTO "public"."student" VALUES (257, 0, 'NY24/273', 5, '2024-11-07 00:00:00', 'Disas Damyuga Perara', '', '', '0001-01-01 00:00:00', 0, 0, 1, '', '', '', '', '', '0.5', 150000.0, 0.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (258, 0, 'NY24/274', 5, '2024-11-07 00:00:00', 'Shayara Sayumlee Perera', '', '', '0001-01-01 00:00:00', 0, 0, 14, '', '', '', '', '', '0.5', 150000.0, 0.0, 30000.0, 120000.0, 0, 0);
INSERT INTO "public"."student" VALUES (259, 0, 'NY24/275', 2, '2024-11-08 00:00:00', 'Suhas Dinsara Bandara', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0.5', 150000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (260, 0, 'NY24/276', 7, '2024-11-09 00:00:00', 'Savithi Sanalya Bandara', '', '', '0001-01-01 00:00:00', 0, 0, 3, '', '', '', '', '', '0', 300000.0, 50000.0, 40000.0, 160000.0, 0, 0);
INSERT INTO "public"."student" VALUES (261, 0, 'NY24/277', 2, '2024-11-20 00:00:00', 'Raveen Adith Wijesinghe', '', '', '0001-01-01 00:00:00', 0, 0, 10, '', '', '', '', '', '0', 300000.0, 50000.0, 48000.0, 192000.0, 0, 0);
INSERT INTO "public"."student" VALUES (262, 0, 'NY24/278', 10, '2024-11-26 00:00:00', 'Senuli Vidunima Daranagama', '', '', '0001-01-01 00:00:00', 0, 0, 5, '', '', '', '', '', '0.5', 150000.0, 50000.0, 45000.0, 180000.0, 0, 0);

-- ----------------------------
-- Primary Key structure for table student
-- ----------------------------
ALTER TABLE "public"."student" ADD CONSTRAINT "student_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."student_id_seq"
OWNED BY "public"."student"."id";
SELECT setval('"public"."student_id_seq"', 262, true);
