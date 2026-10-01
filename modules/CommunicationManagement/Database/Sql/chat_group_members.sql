-- ----------------------------
-- Sequence structure for chat_group_members_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."chat_group_members_id_seq";

CREATE SEQUENCE "public"."chat_group_members_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for chat_group_members
-- ----------------------------
DROP TABLE IF EXISTS "public"."chat_group_members";

CREATE TABLE "public"."chat_group_members" (
    "id" int8 NOT NULL DEFAULT nextval('chat_group_members_id_seq'::regclass),
    "chat_group_id" int8 NOT NULL,
    "user_id" int8 NOT NULL,
    "role" varchar(20) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'member',
    "last_read_at" timestamp(0),
    "is_active" bool DEFAULT true,
    "joined_at" timestamp(0),
    "deleted_at" timestamp(0),
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table chat_group_members
-- ----------------------------
ALTER TABLE "public"."chat_group_members" 
ADD CONSTRAINT "chat_group_members_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniqueness constraints
-- ----------------------------
ALTER TABLE "public"."chat_group_members" 
ADD CONSTRAINT "chat_group_members_user_group_unique" UNIQUE ("chat_group_id", "user_id");

-- ----------------------------
-- Check constraints
-- ----------------------------
ALTER TABLE "public"."chat_group_members" 
ADD CONSTRAINT "chat_group_members_role_check" 
CHECK (role IN ('admin', 'member'));

-- ----------------------------
-- Foreign Key constraints
-- ----------------------------
ALTER TABLE "public"."chat_group_members" 
ADD CONSTRAINT "chat_group_members_chat_group_id_fkey" 
FOREIGN KEY ("chat_group_id") REFERENCES "public"."chat_groups" ("id") ON DELETE CASCADE;

ALTER TABLE "public"."chat_group_members" 
ADD CONSTRAINT "chat_group_members_user_id_fkey" 
FOREIGN KEY ("user_id") REFERENCES "public"."user" ("id") ON DELETE CASCADE;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."chat_group_members_id_seq" 
OWNED BY "public"."chat_group_members"."id";

-- ----------------------------
-- Indexes for table chat_group_members
-- ----------------------------
CREATE INDEX "idx_chat_group_members_group_id" ON "public"."chat_group_members" USING btree ("chat_group_id");
CREATE INDEX "idx_chat_group_members_user_id" ON "public"."chat_group_members" USING btree ("user_id");
CREATE INDEX "idx_chat_group_members_active" ON "public"."chat_group_members" USING btree ("is_active");
