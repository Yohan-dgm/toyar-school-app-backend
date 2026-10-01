/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_backend_v1
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 06/10/2025 16:15:00
 */
-- ----------------------------
-- Sequence structure for edu_fb_predefined_answer_sc_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_predefined_answer_sc_id_seq";

CREATE SEQUENCE "public"."edu_fb_predefined_answer_sc_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_predefined_answer_sc
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_predefined_answer_sc";

CREATE TABLE "public"."edu_fb_predefined_answer_sc" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_predefined_answer_sc_id_seq' :: regclass),
    "edu_fb_predefined_question_sc_id" int8,
    "predefined_answer" varchar(255) COLLATE "pg_catalog"."default",
    "marks" int8 DEFAULT 0,
    "is_active" int8,
    "predefined_answer_weight" int8 DEFAULT 0,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fb_predefined_answer_sc (Secondary section specific answers)
-- ----------------------------
-- Subject Mastery answers
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (1, 1, 'Outstanding Mastery', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (2, 1, 'Strong Mastery', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (3, 1, 'Adequate Mastery', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (4, 1, 'Developing Mastery', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (5, 1, 'Requires Remediation', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (6, 2, 'Exceptional Application', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (7, 2, 'Strong Application', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (8, 2, 'Adequate Application', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (9, 2, 'Limited Application', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (10, 2, 'Cannot Apply Knowledge', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Critical Thinking and Analysis answers
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (11, 3, 'Exceptional Analyst', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (12, 3, 'Strong Analytical Skills', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (13, 3, 'Good Analysis', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (14, 3, 'Basic Analysis', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (15, 3, 'Struggles with Analysis', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (16, 4, 'Compelling Arguments', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (17, 4, 'Sound Arguments', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (18, 4, 'Adequate Arguments', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (19, 4, 'Weak Arguments', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (20, 4, 'Cannot Construct Arguments', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Research and Investigation Skills answers
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (21, 5, 'Highly Independent', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (22, 5, 'Mostly Independent', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (23, 5, 'Somewhat Independent', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (24, 5, 'Needs Guidance', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (25, 5, 'Requires Supervision', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (26, 6, 'Excellent Source Skills', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (27, 6, 'Good Source Skills', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (28, 6, 'Adequate Source Skills', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (29, 6, 'Poor Source Skills', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (30, 6, 'Cannot Use Sources', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Communication and Presentation answers
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (31, 7, 'Outstanding Presenter', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (32, 7, 'Strong Presenter', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (33, 7, 'Good Presenter', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (34, 7, 'Nervous Presenter', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (35, 7, 'Avoids Presentations', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (36, 8, 'Exceptional Writer', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (37, 8, 'Strong Writer', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (38, 8, 'Competent Writer', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (39, 8, 'Developing Writer', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (40, 8, 'Struggles with Writing', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Leadership and Initiative answers
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (41, 9, 'Natural Leader', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (42, 9, 'Strong Leader', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (43, 9, 'Occasional Leader', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (44, 9, 'Reluctant Leader', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (45, 9, 'Prefers Following', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (46, 10, 'Highly Proactive', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (47, 10, 'Usually Proactive', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (48, 10, 'Sometimes Proactive', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (49, 10, 'Rarely Proactive', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (50, 10, 'Passive Learner', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Independent Learning answers
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (51, 11, 'Excellent Self-Learner', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (52, 11, 'Good Self-Learner', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (53, 11, 'Adequate Self-Learning', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (54, 11, 'Struggles with Independence', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (55, 11, 'Requires Constant Support', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Exam Preparation and Performance answers
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (56, 19, 'Excellent Preparation', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (57, 19, 'Good Preparation', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (58, 19, 'Adequate Preparation', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (59, 19, 'Poor Preparation', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (60, 19, 'No Preparation', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (61, 20, 'Excellent Under Pressure', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (62, 20, 'Good Under Pressure', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (63, 20, 'Average Under Pressure', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (64, 20, 'Struggles Under Pressure', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (65, 20, 'Cannot Handle Pressure', 1, 1, 1, NULL, NULL, NULL, NULL);

-- University and Career Readiness answers
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (66, 21, 'Fully Prepared', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (67, 21, 'Well Prepared', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (68, 21, 'Adequately Prepared', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (69, 21, 'Needs Preparation', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (70, 21, 'Not Ready', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (71, 22, 'Career Ready', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (72, 22, 'Nearly Career Ready', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (73, 22, 'Developing Career Skills', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (74, 22, 'Limited Career Readiness', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_sc" VALUES (75, 22, 'Not Career Ready', 1, 1, 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table edu_fb_predefined_answer_sc
-- ----------------------------
ALTER TABLE
    "public"."edu_fb_predefined_answer_sc"
ADD
    CONSTRAINT "edu_fb_predefined_answer_sc_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_predefined_answer_sc_id_seq" OWNED BY "public"."edu_fb_predefined_answer_sc"."id";

SELECT
    setval(
        '"public"."edu_fb_predefined_answer_sc_id_seq"',
        75,
        true
    );