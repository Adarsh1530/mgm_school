from PIL import Image

# 1. GDC: 1750242752.jpeg
# Original is 1600x1600. Outer leaf border is ~33px. Top has black backdrop from y=33 to ~534.
im_gdc = Image.open('assets/images/1750242752.jpeg')
# Let's inspect rows around y=530 to find where black ends and stage begins
# Stage backdrop has purple banner at y > 530
crop_gdc = im_gdc.crop((34, 534, 1566, 1566))
crop_gdc.save('assets/images/gdc-clean.jpeg', quality=95)
print(f"GDC clean: {crop_gdc.size}")

# 2. Counselling Centre: 1750242779.jpeg
# Original is 1600x1600. Outer leaf border is ~33px. Letterbox black bars at y in [33, 185] and [1414, 1566].
im_counsel = Image.open('assets/images/1750242779.jpeg')
crop_counsel = im_counsel.crop((34, 186, 1566, 1414))
crop_counsel.save('assets/images/counselling-centre-clean.jpeg', quality=95)
print(f"Counselling clean: {crop_counsel.size}")

# 3. Amma School: 1750242823.jpeg
# Original is 1600x1600. Outer leaf border is ~33px.
im_amma = Image.open('assets/images/1750242823.jpeg')
crop_amma = im_amma.crop((34, 34, 1566, 1566))
crop_amma.save('assets/images/amma-school-clean.jpeg', quality=95)
print(f"Amma school clean: {crop_amma.size}")

# 4. Voice of MGM: User provided studio photo (control room + broadcast booth)
# Original user photo media_1793081358217_e0ff2c6a.png (759x761)
im_radio = Image.open('C:/Users/KEERTHI ADARSH M P/.gemini/antigravity/brain/a8cc6e3b-cc2d-4829-b39e-c77bd21ddcac/.user_uploaded/media_1793081358217_e0ff2c6a.png')
crop_radio = im_radio.crop((0, 0, 759, 759)).convert('RGB')
crop_radio.save('assets/images/voice-of-mgm-clean.jpeg', quality=95)
crop_radio.save('public/assets/images/voice-of-mgm-clean.jpeg', quality=95)
print(f"Voice of MGM clean: {crop_radio.size}")

# 5. Life Skills: 1751285591.jpeg
# Original is 1600x1135.
# Let's inspect borders of 1751285591.jpeg
im_life = Image.open('assets/images/1751285591.jpeg')
# Has outer black margin ~30px.
crop_life = im_life.crop((36, 36, 1564, 1100))
crop_life.save('assets/images/life-skills-clean.jpeg', quality=95)
print(f"Life Skills clean: {crop_life.size}")

# Also let's inspect 1751285627.jpeg for Happiness Room
im_happy = Image.open('assets/images/1751285627.jpeg')
# Clean 1280x773 photo without any border
im_happy.save('assets/images/happiness-room-clean.jpeg', quality=95)
print(f"Happiness room clean: {im_happy.size}")
