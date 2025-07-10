-- ----------------------------
-- Sequence structure for activity_feed_media_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."activity_feed_media_id_seq";

CREATE SEQUENCE "public"."activity_feed_media_id_seq"
    INCREMENT 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    START 1
    CACHE 1;

-- ----------------------------
-- Table structure for activity_feed_media
-- ----------------------------
DROP TABLE IF EXISTS "public"."activity_feed_media";

CREATE TABLE "public"."activity_feed_media" (
    "id" int8 NOT NULL DEFAULT nextval('activity_feed_media_id_seq' :: regclass),
    "post_id" int8 NOT NULL,
    "type" varchar(20) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'image',
    "url" varchar(500) COLLATE "pg_catalog"."default" NOT NULL,
    "thumbnail_url" varchar(500) COLLATE "pg_catalog"."default",
    "filename" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
    "size" int8 NOT NULL DEFAULT 0,
    "mime_type" varchar(100) COLLATE "pg_catalog"."default",
    "sort_order" int4 NOT NULL DEFAULT 0,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of activity_feed_media
-- ----------------------------
INSERT INTO "public"."activity_feed_media" VALUES
(1, 1, 'image', '/storage/activity-feed/welcome-banner.jpg', '/storage/activity-feed/thumbs/welcome-banner.jpg', 'welcome-banner.jpg', 245760, 'image/jpeg', 1, 1, NULL, '2024-01-15 09:00:00', '2024-01-15 09:00:00'),
(2, 2, 'image', '/storage/activity-feed/sports-day-poster.jpg', '/storage/activity-feed/thumbs/sports-day-poster.jpg', 'sports-day-poster.jpg', 189440, 'image/jpeg', 1, 1, NULL, '2024-01-20 10:30:00', '2024-01-20 10:30:00'),
(3, 2, 'pdf', '/storage/activity-feed/sports-day-schedule.pdf', NULL, 'sports-day-schedule.pdf', 524288, 'application/pdf', 2, 1, NULL, '2024-01-20 10:30:00', '2024-01-20 10:30:00'),
(4, 3, 'image', '/storage/activity-feed/science-lab-1.jpg', '/storage/activity-feed/thumbs/science-lab-1.jpg', 'science-lab-1.jpg', 312320, 'image/jpeg', 1, 1, NULL, '2024-01-25 14:15:00', '2024-01-25 14:15:00'),
(5, 3, 'image', '/storage/activity-feed/science-lab-2.jpg', '/storage/activity-feed/thumbs/science-lab-2.jpg', 'science-lab-2.jpg', 298240, 'image/jpeg', 2, 1, NULL, '2024-01-25 14:15:00', '2024-01-25 14:15:00'),
(6, 4, 'image', '/storage/activity-feed/math-competition-winners.jpg', '/storage/activity-feed/thumbs/math-competition-winners.jpg', 'math-competition-winners.jpg', 267520, 'image/jpeg', 1, 1, NULL, '2024-02-01 11:45:00', '2024-02-01 11:45:00'),
(7, 4, 'video', '/storage/activity-feed/award-ceremony.mp4', '/storage/activity-feed/thumbs/award-ceremony.jpg', 'award-ceremony.mp4', 15728640, 'video/mp4', 2, 1, NULL, '2024-02-01 11:45:00', '2024-02-01 11:45:00'),
(8, 5, 'pdf', '/storage/activity-feed/health-safety-guidelines.pdf', NULL, 'health-safety-guidelines.pdf', 1048576, 'application/pdf', 1, 1, NULL, '2024-02-05 08:30:00', '2024-02-05 08:30:00');

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."activity_feed_media_id_seq" OWNED BY "public"."activity_feed_media"."id";

-- ----------------------------
-- Primary Key structure for table activity_feed_media
-- ----------------------------
ALTER TABLE "public"."activity_feed_media" ADD CONSTRAINT "activity_feed_media_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes for table activity_feed_media
-- ----------------------------
CREATE INDEX "idx_activity_feed_media_post_id" ON "public"."activity_feed_media" USING btree ("post_id");
CREATE INDEX "idx_activity_feed_media_type" ON "public"."activity_feed_media" USING btree ("type");

-- ----------------------------
-- Foreign Keys structure for table activity_feed_media
-- ----------------------------
ALTER TABLE "public"."activity_feed_media" ADD CONSTRAINT "fk_activity_feed_media_post_id" FOREIGN KEY ("post_id") REFERENCES "public"."activity_feed_posts" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;
