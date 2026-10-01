-- Add is_pinned column to chat_group_members table
ALTER TABLE "public"."chat_group_members" 
ADD COLUMN "is_pinned" bool DEFAULT false;

-- Add index for performance when filtering/sorting by user and pin status
CREATE INDEX "idx_chat_group_members_user_pin" ON "public"."chat_group_members" USING btree ("user_id", "is_pinned");
