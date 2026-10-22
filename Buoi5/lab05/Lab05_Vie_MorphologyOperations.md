|     |     | LAB | 05: | Morphological |          |        | Operations |     |
| --- | --- | --- | --- | ------------- | -------- | ------ | ---------- | --- |
|     |     |     |     |               | Computer | Vision |            |     |
2025-2026
| 1   | Mục      | tiêu | bài | học |     |     |     |     |
| --- | -------- | ---- | --- | --- | --- | --- | --- | --- |
|     | Mục tiêu |      |     |     |     |     |     |     |
Sau khi hoàn thành bài thực hành này, người học cần đạt được các mục tiêu sau:
1. Hiểu được bản chất của các phép toán hình thái học trong xử lý ảnh.
|     | 2. Phân | biệt   | được       | vai trò | của các   | phép: |            |     |
| --- | ------- | ------ | ---------- | ------- | --------- | ----- | ---------- | --- |
|     |         | • Co   | (Erosion)  |         |           |       |            |     |
|     |         | • Giãn | (Dilation) |         |           |       |            |     |
|     |         | • Mở   | (Opening)  |         |           |       |            |     |
|     |         | • Đóng | (Closing)  |         |           |       |            |     |
|     | 3. Biết | cách   | áp dụng    | các     | phép toán | hình  | thái trên: |     |
|     |         | • ảnh  | xám,       |         |           |       |            |     |
|     |         | • ảnh  | nhị phân,  |         |           |       |            |     |
|     |         |        |            |         | →         |       | →          | →   |
• và quy trình ảnh xám ngưỡng hóa ảnh nhị phân xử lý hình thái.
4. Hiểu được ảnh hưởng của kernel/structuring element đến kết quả xử lý.
5. Biết sử dụng hình thái học để xử lý một số hiện tượng thường gặp trong ảnh
|     | thực | tế,   | đặc biệt  | là:    |           |     |     |     |
| --- | ---- | ----- | --------- | ------ | --------- | --- | --- | --- |
|     |      | • mép | răng      | cưa,   |           |     |     |     |
|     |      | • các | gai nhỏ   | ở rìa, |           |     |     |     |
|     |      | • lỗ  | trống nhỏ | trong  | vật thể,  |     |     |     |
|     |      | • các | điểm      | nhiễu  | sáng/tối, |     |     |     |
• các vùng tế bào hoặc vùng tổn thương y tế có biên không đều.
6. Biết phân tích vì sao thứ tự áp dụng các phép khác nhau lại cho kết quả
|     | khác | nhau. |        |     |      |     |     |     |
| --- | ---- | ----- | ------ | --- | ---- | --- | --- | --- |
| 2   | Cơ   | sở lý | thuyết |     | ngắn | gọn |     |     |
Hình thái học (morphology) là nhóm phương pháp xử lý ảnh dựa trên hình dạng của
đối tượng. Ý tưởng chính là dùng một phần tử cấu trúc gọi là structuring element hay
1

kernel để “quét” qua ảnh và làm thay đổi hình dạng các vùng sáng/tối theo quy tắc nhất
định.
Trong ảnh nhị phân, các phép toán hình thái thường tác động trực tiếp lên các vùng có
giá trị 1 (hoặc 255). Trong ảnh xám, các phép toán hình thái được hiểu theo nghĩa cực trị
cục bộ:
• Giãn trên ảnh xám: tại mỗi vị trí, giá trị đầu ra thường là giá trị lớn nhất trong
| vùng | kernel. |     |     |     |     |
| ---- | ------- | --- | --- | --- | --- |
• Co trên ảnh xám: tại mỗi vị trí, giá trị đầu ra thường là giá trị nhỏ nhất trong
| vùng | kernel. |     |     |     |     |
| ---- | ------- | --- | --- | --- | --- |
Từ đó:
|     |     | Mở  | = Co rồi Giãn, | Đóng = | Giãn rồi Co |
| --- | --- | --- | -------------- | ------ | ----------- |
Các phép này rất hữu ích trong ảnh y tế và ảnh tế bào, vì đường biên đối tượng thường
không mượt, có mấu nhỏ, có lỗ thủng nhỏ, hoặc có vùng dính nhau do nhiễu hay quá trình
tạo ảnh.
| 3 Minh | họa | trực | quan | về morphology |     |
| ------ | --- | ---- | ---- | ------------- | --- |
Hình dưới đây minh họa trực quan tác động điển hình của bốn phép cơ bản trên một vật
| thể có | biên lồi lõm, | có gai | nhỏ và có lỗ | rỗ nhỏ.   |                 |
| ------ | ------------- | ------ | ------------ | --------- | --------------- |
|        |               |        | Co           | (Erosion) | Giãn (Dilation) |
|        | Ảnh ban đầu   |        |              |           |                 |
Nhận xét nhanh
|     | Mở (Opening) |     | Đóng | (Closing) |     |
| --- | ------------ | --- | ---- | --------- | --- |
• Co: làm mòn biên,
loại gai nhỏ.
• Giãn: làm dày vùng
sáng, dễ nối vùng
gần nhau.
• Mở: bỏ chi tiết lồi
nhỏ,làmmượtbiên.
• Đóng: lấp lỗ và khe
hẹp, làm liền vùng.
Hình 1: Minh họa trực quan tác động của các phép morphology cơ bản.
| 4 Sơ | đồ structuring |     | element |     |     |
| ---- | -------------- | --- | ------- | --- | --- |
Các phần tử cấu trúc khác nhau sẽ tạo ra các kiểu tác động khác nhau lên hình dạng đối
| tượng. | Hình sau mô | tả ba | loại structuring | element thường | gặp. |
| ------ | ----------- | ----- | ---------------- | -------------- | ---- |
2

| Kernel | vuông | 3×3 |     | Kernel cross | 3×3 | Kernel ellipse | 5×5 |
| ------ | ----- | --- | --- | ------------ | --- | -------------- | --- |
Hình 2: Ví dụ về các structuring element thường dùng trong xử lý hình thái.
| Gợi     | ý lý thuyết |     |     |     |     |     |     |
| ------- | ----------- | --- | --- | --- | --- | --- | --- |
| Ý nghĩa | thực tế:    |     |     |     |     |     |     |
• Kernel vuông/chữ nhật: tác động khá mạnh, dễ làm dày hoặc mòn theo cả
|     | ngang và | dọc. |     |     |     |     |     |
| --- | -------- | ---- | --- | --- | --- | --- | --- |
• Kernel ellipse: phù hợp hơn với đối tượng tròn hoặc gần tròn như tế bào, nhân
tế bào.
• Kernel cross: tác động ưu tiên theo trục ngang/dọc, ít mạnh hơn ở các góc
chéo.
Với ảnh tế bào, nhiều khi kernel ellipse cho kết quả tự nhiên hơn kernel vuông.
| 5 Dữ  | liệu          | và công |        | cụ sử dụng |     |     |     |
| ----- | ------------- | ------- | ------ | ---------- | --- | --- | --- |
| Trong | bài thực hành | này,    | có thể | dùng:      |     |     |     |
• Python
• numpy
• opencv-python
• matplotlib
| Cài         | đặt thư viện:     |               |        |            |     |        |     |
| ----------- | ----------------- | ------------- | ------ | ---------- | --- | ------ | --- |
| pip install | numpy             | opencv-python |        | matplotlib |     |        |     |
| 6 Khởi      | tạo               | môi           | trường | và các     | hàm | hỗ trợ |     |
| import      | cv2               |               |        |            |     |        |     |
| import      | numpy as          | np            |        |            |     |        |     |
| import      | matplotlib.pyplot |               | as plt |            |     |        |     |
def show_images(images, titles, cmap='gray', figsize=(14, 6)):
| n   | = len(images) |     |     |     |     |     |     |
| --- | ------------- | --- | --- | --- | --- | --- | --- |
plt.figure(figsize=figsize)
| for | i in range(n): |     |        |     |     |     |     |
| --- | -------------- | --- | ------ | --- | --- | --- | --- |
|     | plt.subplot(1, |     | n, i + | 1)  |     |     |     |
3

|     | if len(images[i].shape) |                       |     |     | == 2:      |     |     |     |
| --- | ----------------------- | --------------------- | --- | --- | ---------- | --- | --- | --- |
|     |                         | plt.imshow(images[i], |     |     | cmap=cmap) |     |     |     |
else:
|     |     | plt.imshow(cv2.cvtColor(images[i], |     |     |     |     | cv2.COLOR_BGR2RGB)) |     |
| --- | --- | ---------------------------------- | --- | --- | --- | --- | ------------------- | --- |
plt.title(titles[i])
plt.axis('off')
plt.tight_layout()
plt.show()
| Đọc | ảnh | xám: |     |     |     |     |     |     |
| --- | --- | ---- | --- | --- | --- | --- | --- | --- |
img = cv2.imread("medical_or_cell_image.png", cv2.IMREAD_GRAYSCALE)
| print(img.shape,   |     |                    | img.dtype) |         |        |                    |         |     |
| ------------------ | --- | ------------------ | ---------- | ------- | ------ | ------------------ | ------- | --- |
| show_images([img], |     |                    | ["Ảnh      | xám đầu | vào"]) |                    |         |     |
| Ngưỡng             | hóa | sang               | ảnh nhị    | phân:   |        |                    |         |     |
| _, binary          | =   | cv2.threshold(img, |            | 127,    | 255,   | cv2.THRESH_BINARY) |         |     |
| show_images([img,  |     |                    | binary],   | ["Ảnh   | xám",  | "Ảnh ịnh           | phân"]) |     |
Trong ảnh y tế hoặc ảnh tế bào, ngưỡng cố định có thể không tốt. Khi đó nên dùng
Otsu:
| _, binary_otsu |     | =    | cv2.threshold(    |     |                   |     |     |     |
| -------------- | --- | ---- | ----------------- | --- | ----------------- | --- | --- | --- |
| img,           | 0,  | 255, | cv2.THRESH_BINARY |     | + cv2.THRESH_OTSU |     |     |     |
)
show_images([img, binary_otsu], ["Ảnh xám", "ịNh phân ằbng Otsu"])
| 7 Structuring |     |     | Element |     | (Kernel) |     |     |     |
| ------------- | --- | --- | ------- | --- | -------- | --- | --- | --- |
Kernel quyết định mức độ và kiểu tác động của phép toán hình thái. Một số kernel thường
dùng:
| kernel_3 | = np.ones((3, |     | 3), | np.uint8) |     |     |     |     |
| -------- | ------------- | --- | --- | --------- | --- | --- | --- | --- |
| kernel_5 | = np.ones((5, |     | 5), | np.uint8) |     |     |     |     |
ellipse_5 = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
| cross_5 | = cv2.getStructuringElement(cv2.MORPH_CROSS, |     |     |     |     |     |     | (5, 5)) |
| ------- | -------------------------------------------- | --- | --- | --- | --- | --- | --- | ------- |
print(kernel_3)
print(ellipse_5)
print(cross_5)
| 8 Phép |         | co  | (Erosion) |     |     |     |     |     |
| ------ | ------- | --- | --------- | --- | --- | --- | --- | --- |
| 8.1    | Ý nghĩa |     |           |     |     |     |     |     |
Co làm thu nhỏ vùng sáng trong ảnh nhị phân, hoặc làm giảm mức sáng cục bộ trong
| ảnh xám. | Trực | quan, | nó có      | xu hướng: |     |     |     |     |
| -------- | ---- | ----- | ---------- | --------- | --- | --- | --- | --- |
| • làm    | mòn  | biên  | đối tượng, |           |     |     |     |     |
4

| • loại | bỏ  | các điểm | sáng | nhỏ,     |         |      |     |
| ------ | --- | -------- | ---- | -------- | ------- | ---- | --- |
| • cắt  | bớt | các gai  | nhỏ  | ở mép,   |         |      |     |
| • tách | các | vùng     | nối  | với nhau | bằng cổ | hẹp. |     |
Trong ảnh tế bào hay ảnh y tế, co hữu ích khi biên đối tượng có các răng cưa nhỏ, có
các chấm sáng nhiễu bám quanh biên, hoặc các tế bào dính nhau bởi cầu nối rất hẹp.
| 8.2 | Co  | trên | ảnh | xám: cách | hiểu | theo | thuật toán |
| --- | --- | ---- | --- | --------- | ---- | ---- | ---------- |
Với mỗi điểm ảnh, lấy cửa sổ lân cận theo kernel, đầu ra là giá trị nhỏ nhất trong vùng
đó.
| Ví                               | dụ minh | họa                     | bằng                         | NumPy            | từ cơ        | sở:        |          |
| -------------------------------- | ------- | ----------------------- | ---------------------------- | ---------------- | ------------ | ---------- | -------- |
| def grayscale_erosion_numpy(img, |         |                         |                              |                  | ksize=3):    |            |          |
| pad                              | =       | ksize                   | // 2                         |                  |              |            |          |
| padded                           |         | = np.pad(img,           |                              | pad,             | mode='edge') |            |          |
| out                              | =       | np.zeros_like(img)      |                              |                  |              |            |          |
| for                              | i       | in range(img.shape[0]): |                              |                  |              |            |          |
|                                  | for     | j in                    | range(img.shape[1]):         |                  |              |            |          |
|                                  |         | region                  | = padded[i:i+ksize,          |                  |              | j:j+ksize] |          |
|                                  |         | out[i,                  | j]                           | = np.min(region) |              |            |          |
| return                           |         | out                     |                              |                  |              |            |          |
| Dùng                             | thử:    |                         |                              |                  |              |            |          |
| eroded_gray_np                   |         | =                       | grayscale_erosion_numpy(img, |                  |              |            | ksize=3) |
show_images([img, eroded_gray_np], ["Ảnh xám ốgc", "Co ảnh xám (NumPy)"])
| 8.3 | Co  | bằng | OpenCV |     |     |     |     |
| --- | --- | ---- | ------ | --- | --- | --- | --- |
kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (3, 3))
| eroded_gray |     | = cv2.erode(img,         |     | kernel, |     | iterations=1) |               |
| ----------- | --- | ------------------------ | --- | ------- | --- | ------------- | ------------- |
| eroded_bin  |     | = cv2.erode(binary_otsu, |     |         |     | kernel,       | iterations=1) |
show_images(
| [img, |     | eroded_gray, |     | binary_otsu, |     | eroded_bin], |     |
| ----- | --- | ------------ | --- | ------------ | --- | ------------ | --- |
["Ảnh xám", "Co trên ảnh xám", "Ảnh ịnh phân", "Co trên ảnh ịnh phân"],
| figsize=(16, |     |     | 8)  |     |     |     |     |
| ------------ | --- | --- | --- | --- | --- | --- | --- |
)
| 8.4 | Phân | tích | kết | quả |     |     |     |
| --- | ---- | ---- | --- | --- | --- | --- | --- |
Trên ảnh xám. Các vùng sáng nhỏ hoặc chi tiết mảnh bị suy giảm, biên sáng bị “co
| vào”, các | vùng | tối | có xu | hướng lan | ra tương | đối. |     |
| --------- | ---- | --- | ----- | --------- | -------- | ---- | --- |
5

Trên ảnh nhị phân. Vật thể trắng bị nhỏ đi, các nhánh hoặc gai mảnh có thể biến mất,
nếu kernel quá lớn thì vật thể nhỏ có thể bị mất hoàn toàn.
Trong ảnh tế bào, co có thể giúp bỏ bớt các rìa gai nhỏ do nhiễu, nhưng nếu dùng quá
mạnh có thể làm sai diện tích và hình dạng thật của tế bào.
Bài tập mở rộng sau phần Co
1. Thử co với kernel (3,3), (5,5), (7,7) và so sánh diện tích đối tượng sau xử lý.
2. Thử dùng kernel vuông và kernel ellipse trên ảnh tế bào, nhận xét kernel nào
giữ biên tự nhiên hơn.
3. Trên một ảnh có hai tế bào dính nhau bằng một cổ mảnh, thử tăng số lần
iterations để xem từ khi nào hai đối tượng tách rời.
9 Phép giãn (Dilation)
9.1 Ý nghĩa
Giãn làm mở rộng vùng sáng trong ảnh nhị phân, hoặc làm tăng cường sáng cục bộ trong
ảnh xám. Nó có xu hướng:
• làm dày vật thể,
• lấp các khe hẹp,
• nối các vùng sáng gần nhau,
• làm đầy các lỗ nhỏ nếu lỗ rất nhỏ so với kernel.
Trong ảnh y tế, giãn có thể dùng để khôi phục phần đối tượng bị đứt nhẹ sau ngưỡng
hóa, kết nối vùng tổn thương hoặc vùng mô bị phân mảnh, và làm rõ hơn các cấu trúc mảnh
trước khi phân tích vùng.
9.2 Giãn trên ảnh xám: cách hiểu theo thuật toán
Với mỗi vị trí, xét vùng lân cận theo kernel, đầu ra là giá trị lớn nhất trong vùng đó.
Cài đặt bằng NumPy:
def grayscale_dilation_numpy(img, ksize=3):
pad = ksize // 2
padded = np.pad(img, pad, mode='edge')
out = np.zeros_like(img)
for i in range(img.shape[0]):
for j in range(img.shape[1]):
region = padded[i:i+ksize, j:j+ksize]
out[i, j] = np.max(region)
return out
Dùng thử:
6

| dilated_gray_np |     |     | = grayscale_dilation_numpy(img, |     |     |     | ksize=3) |
| --------------- | --- | --- | ------------------------------- | --- | --- | --- | -------- |
show_images([img, dilated_gray_np], ["Ảnh xám ốgc", "Giãn ảnh xám (NumPy)"])
| 9.3 | Giãn | bằng | OpenCV |     |     |     |     |
| --- | ---- | ---- | ------ | --- | --- | --- | --- |
kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (3, 3))
| dilated_gray |     | = cv2.dilate(img,         |     |     | kernel, | iterations=1) |               |
| ------------ | --- | ------------------------- | --- | --- | ------- | ------------- | ------------- |
| dilated_bin  |     | = cv2.dilate(binary_otsu, |     |     |         | kernel,       | iterations=1) |
show_images(
| [img, |     | dilated_gray, |     | binary_otsu, |     | dilated_bin], |     |
| ----- | --- | ------------- | --- | ------------ | --- | ------------- | --- |
["Ảnh xám", "Giãn trên ảnh xám", "Ảnh ịnh phân", "Giãn trên ảnh ịnh phân"],
| figsize=(16, |     |     | 8)  |     |     |     |     |
| ------------ | --- | --- | --- | --- | --- | --- | --- |
)
| 9.4 | Phân | tích | kết | quả |     |     |     |
| --- | ---- | ---- | --- | --- | --- | --- | --- |
Trên ảnh xám. Các vùng sáng lan rộng, các thung lũng tối nhỏ có thể bị lấp bớt, biên
| vùng sáng | có  | thể | dày hơn. |     |     |     |     |
| --------- | --- | --- | -------- | --- | --- | --- | --- |
Trên ảnh nhị phân. Vật thể trắng nở ra, khe hở nhỏ bị lấp, các đối tượng ở gần nhau
| có thể | dính | vào nhau. |     |     |     |     |     |
| ------ | ---- | --------- | --- | --- | --- | --- | --- |
Trong ảnh tế bào, giãn có thể có lợi khi biên bị khuyết nhẹ, nhưng có thể làm hai tế bào
| gần nhau | nhập | thành   | một | khối.    |      |     |     |
| -------- | ---- | ------- | --- | -------- | ---- | --- | --- |
| Bài      | tập  | mở rộng |     | sau phần | Giãn |     |     |
1. Dùng giãn trên ảnh có các lỗ hẹp hoặc biên đứt đoạn, quan sát sự kết nối vùng.
2. Thử tăng iterations từ 1 đến 3 và phân tích khi nào các đối tượng riêng biệt
|     | bắt | đầu dính | lại. |     |     |     |     |
| --- | --- | -------- | ---- | --- | --- | --- | --- |
3. So sánh giãn trên ảnh xám và trên ảnh đã ngưỡng hóa, nêu sự khác biệt về mức
|      | kiểm | soát  | hình | dạng.     |     |     |     |
| ---- | ---- | ----- | ---- | --------- | --- | --- | --- |
| 10   | Phép | mở    |      | (Opening) |     |     |     |
| 10.1 | Định | nghĩa |      |           |     |     |     |
→
|     |     |     |     | Opening |     | = Erosion | Dilation |
| --- | --- | --- | --- | ------- | --- | --------- | -------- |
Tức là trước tiên co để loại bỏ các chi tiết nhỏ lồi ra ngoài, sau đó giãn lại để khôi phục
| tương     | đối kích | thước     | chính. |           |     |     |     |
| --------- | -------- | --------- | ------ | --------- | --- | --- | --- |
| 10.2      | Ý        | nghĩa     | trực   | quan      |     |     |     |
| Mở thường |          | được dùng |        | để:       |     |     |     |
| • loại    | bỏ       | các điểm  |        | sáng nhỏ, |     |     |     |
7

• làm mượt các gai lồi ở biên,
• loại các vật thể nhỏ không mong muốn,
• giữ lại cấu trúc chính nếu nó đủ lớn so với kernel.
Đây là phép rất hữu ích với ảnh tế bào hay vùng tổn thương có biên gai, lởm chởm.
10.3 Mở bằng cách xây dựng từng bước
kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
# ựT làm ừtng ướbc
temp = cv2.erode(binary_otsu, kernel, iterations=1)
opened_manual = cv2.dilate(temp, kernel, iterations=1)
# ọGi ựtrc ếtip
opened_cv = cv2.morphologyEx(binary_otsu, cv2.MORPH_OPEN, kernel)
show_images(
[binary_otsu, temp, opened_manual, opened_cv],
["Ảnh ịnh phân", "Sau co", "ởM (ừtng ướbc)", "ởM (OpenCV)"],
figsize=(16, 8)
)
Có thể áp dụng cho ảnh xám:
opened_gray = cv2.morphologyEx(img, cv2.MORPH_OPEN, kernel)
show_images([img, opened_gray], ["Ảnh xám ốgc", "ởM trên ảnh xám"])
10.4 Phân tích kết quả
Mở có tác dụng mạnh với nhiễu sáng nhỏ, mấu lồi nhỏ, các “gai” bám trên mép. Trên ảnh
y tế và ảnh tế bào, mở thường giúp làm trơn đường viền, bỏ các phần lồi giả do nhiễu, giữ
vùng chính ổn định hơn so với chỉ co đơn thuần. Tuy nhiên, nếu kernel lớn quá, mở có thể
làm mất các cấu trúc mảnh thật sự quan trọng.
Bài tập mở rộng sau phần Mở
1. Trên ảnh tế bào có mép răng cưa, thử phép mở với kernel ellipse (3,3), (5,5),
(7,7).
2. So sánh ảnh sau mở với ảnh sau co đơn thuần. Giải thích vì sao mở thường
“hiền” hơn co nếu mục tiêu là làm mượt biên.
3. Tìm trường hợp mà mở làm mất một cấu trúc quan trọng và giải thích nguyên
nhân.
8

| 11 Phép |      | đóng  | (Closing) |         |     |            |           |     |
| ------- | ---- | ----- | --------- | ------- | --- | ---------- | --------- | --- |
| 11.1    | Định | nghĩa |           |         |     |            |           |     |
|         |      |       |           | Closing |     | = Dilation | → Erosion |     |
Tức là giãn trước để lấp khe hở nhỏ hoặc lỗ nhỏ, sau đó co lại để tránh vật thể phình
to quá mức.
| 11.2        | Ý nghĩa |            | trực    | quan  |       |           |     |     |
| ----------- | ------- | ---------- | ------- | ----- | ----- | --------- | --- | --- |
| Đóng thường |         | được dùng  | để:     |       |       |           |     |     |
| • lấp       | các     | lỗ tối nhỏ | bên     | trong | vật   | thể sáng, |     |     |
| • nối       | các     | khe đứt    | hẹp ở   | biên, |       |           |     |     |
| • làm       | mượt    | vùng       | lõm nhỏ | trên  | đường | biên,     |     |     |
| • giữ       | vật     | thể liền   | mạch    | hơn.  |       |           |     |     |
Trong ảnh tế bào hoặc ảnh y tế, vùng đối tượng sau ngưỡng hóa có thể có lỗ thủng nhỏ,
biên có thể bị nứt, hở; closing rất hữu ích để làm đầy và làm liền các vùng đó.
| 11.3 | Đóng | bằng | từng | bước |     | và bằng | OpenCV |     |
| ---- | ---- | ---- | ---- | ---- | --- | ------- | ------ | --- |
kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
| temp = cv2.dilate(binary_otsu, |     |                   |     |     | kernel, | iterations=1) |     |     |
| ------------------------------ | --- | ----------------- | --- | --- | ------- | ------------- | --- | --- |
| closed_manual                  |     | = cv2.erode(temp, |     |     | kernel, | iterations=1) |     |     |
closed_cv = cv2.morphologyEx(binary_otsu, cv2.MORPH_CLOSE, kernel)
show_images(
| [binary_otsu, |     |     | temp, | closed_manual, |     | closed_cv], |     |     |
| ------------- | --- | --- | ----- | -------------- | --- | ----------- | --- | --- |
["Ảnh ịnh phân", "Sau giãn", "Đóng (ừtng ướbc)", "Đóng (OpenCV)"],
| figsize=(16, |     | 8)  |     |     |     |     |     |     |
| ------------ | --- | --- | --- | --- | --- | --- | --- | --- |
)
| Áp dụng     |     | trên ảnh                | xám: |     |     |                  |     |         |
| ----------- | --- | ----------------------- | ---- | --- | --- | ---------------- | --- | ------- |
| closed_gray |     | = cv2.morphologyEx(img, |      |     |     | cv2.MORPH_CLOSE, |     | kernel) |
show_images([img, closed_gray], ["Ảnh xám ốgc", "Đóng trên ảnh xám"])
| 11.4 | Phân | tích | kết | quả |     |     |     |     |
| ---- | ---- | ---- | --- | --- | --- | --- | --- | --- |
Đóng đặc biệt hiệu quả khi đối tượng có các lỗ nhỏ bên trong, biên có khe nứt nhỏ, vùng
sáng gần nối nhau nhưng còn gián đoạn rất hẹp. So với mở, mở thiên về bỏ chi tiết sáng
nhỏ bên ngoài, còn đóng thiên về lấp chi tiết tối nhỏ bên trong. Trong ảnh y tế, nếu mask
phân đoạn bị rỗ hoặc có các hố nhỏ, đóng thường là bước hậu xử lý tốt.
9

| Bài | tập | mở  | rộng | sau phần | Đóng |     |     |     |     |     |
| --- | --- | --- | ---- | -------- | ---- | --- | --- | --- | --- | --- |
1. Tạo một ảnh nhị phân có một vật thể chứa vài lỗ nhỏ, áp dụng closing và nhận
|     | xét | khả | năng | lấp lỗ. |     |     |     |     |     |     |
| --- | --- | --- | ---- | ------- | --- | --- | --- | --- | --- | --- |
2. So sánh closing với dilation đơn thuần trong việc nối các khe hở hẹp.
3. Thử kernel vuông và ellipse trên một đối tượng gần tròn, nhận xét ảnh hưởng
|     | đến | độ  | tự nhiên | của biên. |     |       |     |     |          |       |
| --- | --- | --- | -------- | --------- | --- | ----- | --- | --- | -------- | ----- |
| 12  | Quy |     | trình    | thường    |     | dùng: | ảnh | xám | → ngưỡng | hóa → |
|     | xử  | lý  | hình     | thái      |     |       |     |     |          |       |
Trong thực tế, nhất là với ảnh y tế và ảnh tế bào, một quy trình thường gặp là:
| 1.  | Đọc     | ảnh xám. |       |            |      |             |      |      |       |     |
| --- | ------- | -------- | ----- | ---------- | ---- | ----------- | ---- | ---- | ----- | --- |
| 2.  | Tăng    | chất     | lượng | tương phản | nếu  | cần.        |      |      |       |     |
| 3.  | Ngưỡng  | hóa      | để    | tách vật   | thể. |             |      |      |       |     |
| 4.  | Áp dụng | hình     | thái  | học để     | làm  | sạch mask.  |      |      |       |     |
| 5.  | Đo diện | tích,    | chu   | vi, đếm    | đối  | tượng, hoặc | phân | đoạn | tiếp. |     |
Ví dụ:
| img =  | cv2.imread("cell_image.png", |        |      |         |     | cv2.IMREAD_GRAYSCALE) |     |     |     |     |
| ------ | ---------------------------- | ------ | ---- | ------- | --- | --------------------- | --- | --- | --- | --- |
| # ướBc | 1:                           | làm    | ượmt | ẹnh ếnu | ầcn |                       |     |     |     |     |
| blur   | = cv2.GaussianBlur(img,      |        |      |         | (5, | 5), 0)                |     |     |     |     |
| # ướBc | 2:                           | ưỡngng | hóa  |         |     |                       |     |     |     |     |
_, binary = cv2.threshold(blur, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)
| # ướBc | 3:  | ởm để | ỏb  | đểim ễnhiu | sáng | ỏnh / | gai | ỏnh |     |     |
| ------ | --- | ----- | --- | ---------- | ---- | ----- | --- | --- | --- | --- |
kernel_open = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (3, 3))
opened = cv2.morphologyEx(binary, cv2.MORPH_OPEN, kernel_open)
| # ướBc | 4:  | đóng | để ấlp | ỗl ỏnh | trong | đối ượtng |     |     |     |     |
| ------ | --- | ---- | ------ | ------ | ----- | --------- | --- | --- | --- | --- |
kernel_close = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
cleaned = cv2.morphologyEx(opened, cv2.MORPH_CLOSE, kernel_close)
show_images(
| [img, |     | blur, | binary, | opened, |     | cleaned], |     |     |     |     |
| ----- | --- | ----- | ------- | ------- | --- | --------- | --- | --- | --- | --- |
["Ảnh xám", "Làm ượmt", "ưỡNgng hóa", "Sau Opening", "Sau Opening + Closing"
],
| figsize=(18, |     |     | 8)  |     |     |     |     |     |     |     |
| ------------ | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
)
10

| 12.1 Tại |     | sao thứ | tự  | này | hợp | lý? |     |     |     |     |     |     |
| -------- | --- | ------- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
• Opening trước: bỏ những chi tiết sáng nhỏ, mấu nhỏ, nhiễu bám quanh biên.
• Closing sau: lấp các lỗ nhỏ còn sót lại bên trong vùng đối tượng.
Nếu làm ngược lại, closing trước có thể làm nhiễu sáng nhỏ dày lên; sau đó opening chưa
chắc loại bỏ được hoàn toàn hoặc có thể làm biến dạng biên khác đi.
| 13 Ví    | dụ  | ứng    | dụng |      | gắn | với  | ảnh  | y   | tế và | ảnh | tế  | bào |
| -------- | --- | ------ | ---- | ---- | --- | ---- | ---- | --- | ----- | --- | --- | --- |
| 13.1 Ảnh |     | tế bào | có   | biên | gai | hoặc | răng | cưa |       |     |     |     |
Sau ngưỡng hóa, tế bào có thể có các nhú nhỏ ở rìa, biên không mượt, hạt sáng nhỏ xung
| quanh. Khi | đó: |          |        |        |      |         |     |       |      |      |     |          |
| ---------- | --- | -------- | ------ | ------ | ---- | ------- | --- | ----- | ---- | ---- | --- | -------- |
| • Opening  |     | giúp     | bỏ các | gai    | nhỏ. |         |     |       |      |      |     |          |
| • Erosion  |     | nhẹ giúp | xem    | mức    | độ   | ổn định | của | biên. |      |      |     |          |
| • Closing  |     | giúp lấp | chỗ    | lõm    | nhỏ  | hoặc lỗ | rỗ. |       |      |      |     |          |
| 13.2 Ảnh   |     | vùng     | tổn    | thương |      | hoặc    | cấu | trúc  | giải | phẫu | bị  | thủng/lỗ |
nhỏ
Sau phân đoạn, mask có thể xuất hiện lỗ nhỏ trong khối đối tượng, biên đứt, khe hở hẹp.
| Khi đó, Closing |     | là lựa | chọn | tốt   | để làm | đầy | và làm | liền. |     |     |     |     |
| --------------- | --- | ------ | ---- | ----- | ------ | --- | ------ | ----- | --- | --- | --- | --- |
| 13.3 Ảnh        |     | có các | đối  | tượng |        | rất | gần    | nhau  |     |     |     |     |
Nếu cần giữ các đối tượng tách biệt thì tránh dilation hoặc closing quá mạnh, và có thể
dùng erosion nhẹ trước. Nếu cần gộp các phần rất gần thì dùng dilation hoặc closing.
| 14 So | sánh |     | bản  | chất  |      | các | phép   |           |     |      |     |      |
| ----- | ---- | --- | ---- | ----- | ---- | --- | ------ | --------- | --- | ---- | --- | ---- |
| Phép  | toán | Tác | động | chính |      |     | Hữu    | ích khi   |     | Nguy |     | cơ   |
| Co    |      | Thu | nhỏ  | vùng  | sáng |     | Bỏ gai | nhỏ, tách | nối | Mất  | chi | tiết |
|       |      |     |      |       |      |     | hẹp    |           |     | mảnh |     |      |
Giãn Mở rộng vùng sáng Nối vùng đứt, làm dày Dính các vật thể
|     |     |     |     |     |     |     | vật thể |     |     | gần | nhau |     |
| --- | --- | --- | --- | --- | --- | --- | ------- | --- | --- | --- | ---- | --- |
Mở Bỏ chi tiết sáng nhỏ, Nhiễu sáng nhỏ, mép Mất cấu trúc nhỏ
|     |     | làm | mượt | biên | lồi |     | gai |     |     | thật |     |     |
| --- | --- | --- | ---- | ---- | --- | --- | --- | --- | --- | ---- | --- | --- |
Đóng Lấp lỗ tối nhỏ, nối Mask bị rỗ, biên nứt Có thể làm dính
|     |     | khe | hẹp |     |     |     |     |     |     | vùng | gần | nhau |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | ---- | --- | ---- |
11

| 15  | Đoạn | mã  | tổng | hợp | để  | tự  | thay | đổi thứ | tự phép | toán |
| --- | ---- | --- | ---- | --- | --- | --- | ---- | ------- | ------- | ---- |
img = cv2.imread("medical_or_cell_image.png", cv2.IMREAD_GRAYSCALE)
| blur = | cv2.GaussianBlur(img, |     |     | (5, | 5), | 0)  |     |     |     |     |
| ------ | --------------------- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
_, binary = cv2.threshold(blur, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)
kernel3 = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (3, 3))
kernel5 = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
| erosion  | =   | cv2.erode(binary,        |     | kernel3, |                  | iterations=1) |     |          |     |     |
| -------- | --- | ------------------------ | --- | -------- | ---------------- | ------------- | --- | -------- | --- | --- |
| dilation | =   | cv2.dilate(binary,       |     |          | kernel3,         | iterations=1) |     |          |     |     |
| opening  | =   | cv2.morphologyEx(binary, |     |          | cv2.MORPH_OPEN,  |               |     | kernel3) |     |     |
| closing  | =   | cv2.morphologyEx(binary, |     |          | cv2.MORPH_CLOSE, |               |     | kernel5) |     |     |
open_then_close = cv2.morphologyEx(opening, cv2.MORPH_CLOSE, kernel5)
close_then_open = cv2.morphologyEx(closing, cv2.MORPH_OPEN, kernel3)
show_images(
[binary, erosion, dilation, opening, closing, open_then_close,
close_then_open],
[
"Binary",
"Erosion",
"Dilation",
"Opening",
"Closing",
|     | "Opening |     | -> Closing", |     |     |     |     |     |     |     |
| --- | -------- | --- | ------------ | --- | --- | --- | --- | --- | --- | --- |
|     | "Closing |     | -> Opening"  |     |     |     |     |     |     |     |
],
| figsize=(20, |     |     | 10) |     |     |     |     |     |     |     |
| ------------ | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
)
| 16   | Bài | tập | cuối   | bài  |      |     |     |            |     |     |
| ---- | --- | --- | ------ | ---- | ---- | --- | --- | ---------- | --- | --- |
| 16.1 | Bài | tập | 1. Làm | sạch | biên | tế  | bào | có gai nhỏ |     |     |
Cho một ảnh tế bào sau ngưỡng hóa, biên của nhiều tế bào có răng cưa và các gai nhỏ.
| Yêu   | cầu: |       |      |                |     |           |          |          |     |     |
| ----- | ---- | ----- | ---- | -------------- | --- | --------- | -------- | -------- | --- | --- |
| 1. Áp | dụng | riêng | từng | phép: erosion, |     | dilation, | opening, | closing. |     |     |
2. So sánh kết quả về: độ mượt của biên, mức giữ được hình dạng tổng thể, nguy cơ làm
| mất    | chi  | tiết thật. |     |         |         |     |         |        |     |     |
| ------ | ---- | ---------- | --- | ------- | ------- | --- | ------- | ------ | --- | --- |
| 3. Kết | luận | phép       | nào | phù hợp | nhất để | khử | gai nhỏ | ở rìa. |     |     |
Gợi ý phân tích: opening thường phù hợp hơn erosion đơn thuần vì sau khi co sẽ có bước
| giãn khôi | phục | tương | đối | hình dạng | chính. |     |     |     |     |     |
| --------- | ---- | ----- | --- | --------- | ------ | --- | --- | --- | --- | --- |
12

16.2 Bài tập 2. Lấp lỗ nhỏ trong vùng tổn thương
Cho một mask nhị phân của vùng tổn thương, trong vùng trắng có nhiều lỗ đen nhỏ.
Yêu cầu:
1. Áp dụng closing với 3 kích thước kernel khác nhau.
2. So sánh khả năng lấp lỗ và mức biến dạng biên ngoài.
3. Giải thích tại sao kernel lớn hơn lấp lỗ tốt hơn nhưng cũng có thể làm thay đổi hình
dạng tổng thể.
16.3 Bài tập 3. So sánh hai chuỗi phép toán
Trên cùng một ảnh nhị phân, hãy tạo hai pipeline:
• Pipeline A: Opening -> Closing
• Pipeline B: Closing -> Opening
Yêu cầu:
1. Hiển thị kết quả của từng bước.
2. So sánh: số điểm nhiễu còn lại, số lỗ nhỏ còn lại, mức độ mượt của biên, khả năng giữ
được kích thước vật thể.
3. Giải thích vì sao hai pipeline cho kết quả khác nhau dù cùng dùng opening và closing.
Gợi ý: thứ tự thao tác quyết định chi tiết nào bị loại bỏ trước, chi tiết nào được lấp
trước.
16.4 Bài tập 4. Tách các tế bào dính nhau nhẹ
Cho một ảnh nhị phân gồm một số tế bào gần nhau, một vài cặp nối với nhau bằng cầu
hẹp.
Yêu cầu:
1. Dùng erosion với nhiều kích thước kernel để thử tách các tế bào.
2. Sau đó dùng dilation để phục hồi tương đối kích thước.
3. So sánh kết quả với opening.
4. Giảithíchtrườnghợpnàoopeninghiệuquảhơnchuỗitựthiếtkếerosion -> dilation,
và vì sao trên thực tế hai kết quả có thể giống hoặc khác nhau tùy tham số.
13

| 16.5 | Bài |     | tập 5. | Phân |     | tích | ảnh hưởng | của hình dạng | kernel |
| ---- | --- | --- | ------ | ---- | --- | ---- | --------- | ------------- | ------ |
Chọn một ảnh có các vật thể gần tròn như tế bào, hồng cầu, bạch cầu hoặc nhân tế bào.
|     | Yêu cầu: |        |          |     |         |      |     |     |     |
| --- | -------- | ------ | -------- | --- | ------- | ---- | --- | --- | --- |
|     | 1. Thực  | hiện   | opening  | và  | closing | với: |     |     |     |
|     | •        | kernel | vuông,   |     |         |      |     |     |     |
|     | •        | kernel | ellipse, |     |         |      |     |     |     |
|     | •        | kernel | cross.   |     |         |      |     |     |     |
2. So sánh: độ tự nhiên của biên, khả năng giữ hình dạng gần tròn, mức xóa nhiễu hoặc
|     | lấp | lỗ. |     |     |     |     |     |     |     |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
3. Giải thích tại sao trong một số bài toán y tế, kernel ellipse thường hợp lý hơn.
| 17  | Câu |     | hỏi | thảo | luận |     | và phân | tích |     |
| --- | --- | --- | --- | ---- | ---- | --- | ------- | ---- | --- |
1. Vì sao phép mở phù hợp để xóa các chi tiết sáng nhỏ lồi ra ngoài, còn phép đóng phù
|     | hợp | để lấp | các | lỗ tối | nhỏ | bên trong? |     |     |     |
| --- | --- | ------ | --- | ------ | --- | ---------- | --- | --- | --- |
2. Trong ảnh tế bào, khi nào việc làm mượt biên bằng hình thái học có thể gây hại cho
|     | phân | tích | y sinh? |     |     |     |     |     |     |
| --- | ---- | ---- | ------- | --- | --- | --- | --- | --- | --- |
3. Vì sao cùng một phép toán nhưng áp dụng trên ảnh xám và ảnh nhị phân lại cho cảm
|     | giác | khác | nhau | về kết | quả? |     |     |     |     |
| --- | ---- | ---- | ---- | ------ | ---- | --- | --- | --- | --- |
4. Nếu mục tiêu là đếm tế bào, bạn sẽ chọn pipeline nào để vừa làm sạch nhiễu vừa hạn
|     | chế | việc | hai tế | bào nhập | vào | nhau? |     |     |     |
| --- | --- | ---- | ------ | -------- | --- | ----- | --- | --- | --- |
5. Khi nào nên tăng kích thước kernel, khi nào nên giữ kernel nhỏ nhưng tăng số lần lặp?
| 18  | Kết      |         | luận   |          |     |          |               |            |     |
| --- | -------- | ------- | ------ | -------- | --- | -------- | ------------- | ---------- | --- |
| Qua | bài thực | hành    | này,   | người    | học | cần      | rút ra các ý  | chính sau: |     |
|     | • Hình   | thái    | học là | công     | cụ  | rất mạnh | để xử lý theo | hình dạng. |     |
|     | • Co     | và giãn | là     | hai phép | cơ  | sở.      |               |            |     |
• Mở và đóng là các tổ hợp cực kỳ hữu ích trong tiền xử lý và hậu xử lý.
• Với ảnh y tế, ảnh tế bào, việc chọn loại ảnh xử lý, kiểu kernel, kích thước kernel, và
đặc biệt là thứ tự các phép toán có ảnh hưởng rất lớn đến chất lượng kết quả cuối
cùng.
14