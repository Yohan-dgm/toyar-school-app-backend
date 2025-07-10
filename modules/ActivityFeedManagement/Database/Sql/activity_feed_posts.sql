-- ----------------------------
-- Sequence structure for activity_feed_posts_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."activity_feed_posts_id_seq";

CREATE SEQUENCE "public"."activity_feed_posts_id_seq"
    INCREMENT 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    START 1
    CACHE 1;

-- ----------------------------
-- Table structure for activity_feed_posts
-- ----------------------------
DROP TABLE IF EXISTS "public"."activity_feed_posts";

CREATE TABLE "public"."activity_feed_posts" (
    "id" int8 NOT NULL DEFAULT nextval('activity_feed_posts_id_seq' :: regclass),
    "type" varchar(50) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'announcement',
    "category" varchar(100) COLLATE "pg_catalog"."default",
    "title" varchar(500) COLLATE "pg_catalog"."default" NOT NULL,
    "content" text COLLATE "pg_catalog"."default" NOT NULL,
    "author_id" int8 NOT NULL,
    "school_id" int8 NOT NULL,
    "class_id" int8,
    "student_id" int8,
    "likes_count" int4 NOT NULL DEFAULT 0,
    "comments_count" int4 NOT NULL DEFAULT 0,
    "is_active" bool NOT NULL DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of activity_feed_posts
-- ----------------------------
INSERT INTO "public"."activity_feed_posts" VALUES
(1, 'announcement', 'General', 'Welcome to New Academic Year 2024', 'We are excited to welcome all students and parents to the new academic year 2024. This year brings new opportunities and challenges. #NewYear #Welcome #Academic2024', 1, 1, NULL, NULL, 15, 8, true, 1, NULL, '2024-01-15 09:00:00', '2024-01-15 09:00:00'),
(2, 'event', 'Sports', 'Annual Sports Day 2024', 'Join us for our Annual Sports Day on March 15th, 2024. Various competitions and activities planned for all age groups. #SportsDay #Competition #Fun', 1, 1, NULL, NULL, 23, 12, true, 1, NULL, '2024-01-20 10:30:00', '2024-01-20 10:30:00'),
(3, 'news', 'Academic', 'New Science Laboratory Opened', 'We are proud to announce the opening of our state-of-the-art science laboratory equipped with modern instruments and safety features. #Science #Laboratory #Education', 1, 1, NULL, NULL, 31, 5, true, 1, NULL, '2024-01-25 14:15:00', '2024-01-25 14:15:00'),
(4, 'achievement', 'Academic', 'Students Win National Math Competition', 'Congratulations to our Grade 10 students who secured first place in the National Mathematics Competition 2024. #Mathematics #Achievement #Pride', 1, 1, NULL, NULL, 45, 18, true, 1, NULL, '2024-02-01 11:45:00', '2024-02-01 11:45:00'),
(5, 'announcement', 'Health', 'Health and Safety Guidelines', 'Important health and safety guidelines for all students and staff. Please follow the protocols mentioned in the detailed document. #Health #Safety #Guidelines', 1, 1, NULL, NULL, 12, 3, true, 1, NULL, '2024-02-05 08:30:00', '2024-02-05 08:30:00');

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."activity_feed_posts_id_seq" OWNED BY "public"."activity_feed_posts"."id";

-- ----------------------------
-- Primary Key structure for table activity_feed_posts
-- ----------------------------
ALTER TABLE "public"."activity_feed_posts" ADD CONSTRAINT "activity_feed_posts_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes for table activity_feed_posts
-- ----------------------------
CREATE INDEX "idx_activity_feed_posts_school_id" ON "public"."activity_feed_posts" USING btree ("school_id");
CREATE INDEX "idx_activity_feed_posts_author_id" ON "public"."activity_feed_posts" USING btree ("author_id");
CREATE INDEX "idx_activity_feed_posts_type" ON "public"."activity_feed_posts" USING btree ("type");
CREATE INDEX "idx_activity_feed_posts_created_at" ON "public"."activity_feed_posts" USING btree ("created_at" DESC);
CREATE INDEX "idx_activity_feed_posts_class_id" ON "public"."activity_feed_posts" USING btree ("class_id");
CREATE INDEX "idx_activity_feed_posts_student_id" ON "public"."activity_feed_posts" USING btree ("student_id");
