|     | LAB | 05: Morphological |          |        | Operations |
| --- | --- | ----------------- | -------- | ------ | ---------- |
|     |     |                   | Computer | Vision |            |
2025-2026
| 1 Learning |            | Objectives |     |     |     |
| ---------- | ---------- | ---------- | --- | --- | --- |
| Learning   | Objectives |            |     |     |     |
After completing this lab, students should be able to achieve the following objectives:
1. Understand the nature of morphological operations in image processing.
|     | 2. Distinguish | the roles | of the following | operations: |     |
| --- | -------------- | --------- | ---------------- | ----------- | --- |
• Erosion
• Dilation
• Opening
• Closing
|     | 3. Know how | to apply | morphological | operations | to: |
| --- | ----------- | -------- | ------------- | ---------- | --- |
|     | • grayscale | images,  |               |            |     |
|     | • binary    | images,  |               |            |     |
• and the workflow grayscale image → thresholding → binary image →
|     | morphological | processing. |     |     |     |
| --- | ------------- | ----------- | --- | --- | --- |
4. Understand the influence of the kernel/structuring element on the process-
ing result.
5. Use morphology to handle common phenomena in real images, especially:
|     | • jagged      | edges,       |             |     |     |
| --- | ------------- | ------------ | ----------- | --- | --- |
|     | • small       | spurs along  | boundaries, |     |     |
|     | • small       | holes inside | objects,    |     |     |
|     | • bright/dark | noise        | points,     |     |     |
• cell regions or medical lesion regions with irregular boundaries.
6. Analyze why different operation orders produce different results.
| 2 Brief | Theoretical |     | Background |     |     |
| ------- | ----------- | --- | ---------- | --- | --- |
Morphology is a group of image processing methods based on the shape of objects. The
core idea is to use a structuring element, also called a kernel, to scan the image and
modify the shape of bright/dark regions according to specific rules.
1

Trong binary images, các phép toán hình thái thường tác động trực tiếp lên các vùng có
giá trị 1 (hoặc 255). Trong grayscale images, các phép toán hình thái được hiểu theo nghĩa
cực trị cục bộ:
• Grayscale dilation: at each position, the output value is usually the maximum value
inside the kernel window.
• Grayscale erosion: at each position, the output value is usually the minimum value
inside the kernel window.
Từ đó:
Opening = Erosion followed by Dilation, Closing = Dilation followed by Erosion
These operations are very useful in medical and cell images because object boundaries
are often irregular, contain small protrusions, small holes, or touching regions caused by
noise or image formation effects.
3 Visual Illustration of Morphology
The figure below visually illustrates the typical effect of the four basic operations on an
object with uneven boundaries, small protrusions, and small holes.
Original image Erosion Dilation
Quick remarks
• Erosion: shrinks
boundaries and re-
Opening Closing moves small spurs.
• Dilation: thickens
bright regions and
can connect nearby
regions.
• Opening: removes
small protru-
sions and smooths
boundaries.
• Closing: fills holes
and narrow gaps,
making regions
more continuous.
Figure 1: Visual illustration of the effect of the basic morphological operations.
2

| 4   | Structuring |     |     | Element |     | Diagram |     |     |     |     |
| --- | ----------- | --- | --- | ------- | --- | ------- | --- | --- | --- | --- |
Differentstructuring elementsproduce differenteffects on object shape. The followingfigure
| shows | three  | common | types | of  | structuring | elements.    |     |     |                |     |
| ----- | ------ | ------ | ----- | --- | ----------- | ------------ | --- | --- | -------------- | --- |
|       | Square | kernel |       | 3×3 |             | Cross kernel | 3×3 |     | Ellipse kernel | 5×5 |
Figure 2: Examples of structuring elements commonly used in morphological processing.
|     | Theory    | Notes    |     |     |     |     |     |     |     |     |
| --- | --------- | -------- | --- | --- | --- | --- | --- | --- | --- | --- |
|     | Practical | meaning: |     |     |     |     |     |     |     |     |
• Square/rectangular kernel: relatively strong effect, easily thickening or
|     |     | shrinking | structures |     | in both | horizontal | and vertical |     | directions. |     |
| --- | --- | --------- | ---------- | --- | ------- | ---------- | ------------ | --- | ----------- | --- |
• Ellipse kernel: more suitable for round or nearly round objects such as cells
|     |     | or cell | nuclei. |     |     |     |     |     |     |     |
| --- | --- | ------- | ------- | --- | --- | --- | --- | --- | --- | --- |
• Cross kernel: emphasizes horizontal/vertical directions and is less aggressive
|     |     | at diagonal | corners. |     |     |     |     |     |     |     |
| --- | --- | ----------- | -------- | --- | --- | --- | --- | --- | --- | --- |
For cell images, an ellipse kernel often produces more natural results than a square
kernel.
| 5   | Data      | and |          | Tools | Used |     |     |     |     |     |
| --- | --------- | --- | -------- | ----- | ---- | --- | --- | --- | --- | --- |
| In  | this lab, | you | may use: |       |      |     |     |     |     |     |
• Python
• numpy
• opencv-python
•
matplotlib
|        | Cài đặt           | thư   | viện:         |       |     |            |        |           |     |     |
| ------ | ----------------- | ----- | ------------- | ----- | --- | ---------- | ------ | --------- | --- | --- |
| pip    | install           | numpy | opencv-python |       |     | matplotlib |        |           |     |     |
| 6      | Environment       |       |               | Setup |     | and        | Helper | Functions |     |     |
| import | cv2               |       |               |       |     |            |        |           |     |     |
| import | numpy             | as    | np            |       |     |            |        |           |     |     |
| import | matplotlib.pyplot |       |               | as    | plt |            |        |           |     |     |
3

def show_images(images, titles, cmap='gray', figsize=(14, 6)):
| n   | = len(images) |     |     |     |     |     |     |
| --- | ------------- | --- | --- | --- | --- | --- | --- |
plt.figure(figsize=figsize)
| for | i in range(n):          |     |      |      |            |     |     |
| --- | ----------------------- | --- | ---- | ---- | ---------- | --- | --- |
|     | plt.subplot(1,          |     | n, i | + 1) |            |     |     |
|     | if len(images[i].shape) |     |      | ==   | 2:         |     |     |
|     | plt.imshow(images[i],   |     |      |      | cmap=cmap) |     |     |
else:
|     | plt.imshow(cv2.cvtErosionlor(images[i], |     |     |     |     |     | cv2.COLOR_BGR2RGB)) |
| --- | --------------------------------------- | --- | --- | --- | --- | --- | ------------------- |
plt.title(titles[i])
plt.axis('off')
plt.tight_layout()
plt.show()
| Read | a grayscale |     | image: |     |     |     |     |
| ---- | ----------- | --- | ------ | --- | --- | --- | --- |
img = cv2.imread("medical_or_cell_image.png", cv2.IMREAD_GRAYSCALE)
| print(img.shape,   |                      | img.dtype) |                   |        |          |                    |     |
| ------------------ | -------------------- | ---------- | ----------------- | ------ | -------- | ------------------ | --- |
| show_images([img], |                      |            | ["Input grayscale |        | image"]) |                    |     |
| Threshold          | to                   | obtain     | a binary          | image: |          |                    |     |
| _, binary          | = cv2.threshold(img, |            |                   | 127,   | 255,     | cv2.THRESH_BINARY) |     |
show_images([img, binary], ["Grayscale image", "Binary image"])
In medical or cell images, a fixed threshold may not work well. In that case, Otsu
| thresholding   | is      | recommended:      |     |     |                   |     |     |
| -------------- | ------- | ----------------- | --- | --- | ----------------- | --- | --- |
| _, binary_otsu |         | = cv2.threshold(  |     |     |                   |     |     |
| img,           | 0, 255, | cv2.THRESH_BINARY |     |     | + cv2.THRESH_OTSU |     |     |
)
show_images([img, binary_otsu], ["Grayscale image", "Binary image using Otsu"])
| 7 Structuring |     |     | Element |     | (Kernel) |     |     |
| ------------- | --- | --- | ------- | --- | -------- | --- | --- |
The kernel determines the strength and type of the morphological effect. Some commonly
| used kernels | are:          |     |               |     |     |     |     |
| ------------ | ------------- | --- | ------------- | --- | --- | --- | --- |
| kernel_3     | = np.ones((3, |     | 3), np.uint8) |     |     |     |     |
| kernel_5     | = np.ones((5, |     | 5), np.uint8) |     |     |     |     |
ellipse_5 = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
| cross_5 | = cv2.getStructuringElement(cv2.MORPH_CROSS, |     |     |     |     |     | (5, 5)) |
| ------- | -------------------------------------------- | --- | --- | --- | --- | --- | ------- |
print(kernel_3)
print(ellipse_5)
print(cross_5)
4

8 Erosion
8.1 Meaning
Erosion làm thu nhỏ vùng sáng trong binary images, hoặc làm giảm mức sáng cục bộ
| trong ảnh  | xám.   | Trực    | quan,       | nó     | có xu | hướng:          |     |
| ---------- | ------ | ------- | ----------- | ------ | ----- | --------------- | --- |
| • erode    | object |         | boundaries, |        |       |                 |     |
| • remove   |        | small   | bright      | spots, |       |                 |     |
| • trim     | small  | spurs   | along       | edges, |       |                 |     |
| • separate |        | regions | connected   |        | by    | narrow bridges. |     |
In cell or medical images, erosion is useful when object boundaries contain small jagged
artifacts, bright noise around the edges, or cells are connected by very narrow bridges.
| 8.2 | Grayscale |     | Erosion: |     | Algorithmic |     | Interpretation |
| --- | --------- | --- | -------- | --- | ----------- | --- | -------------- |
For each pixel, take the neighborhood window defined by the kernel; the output is the
| minimum                          | value                |                      | in that                      | region.          |              |                 |          |
| -------------------------------- | -------------------- | -------------------- | ---------------------------- | ---------------- | ------------ | --------------- | -------- |
| A basic                          | NumPy                |                      | implementation               |                  |              | is shown below: |          |
| def grayscale_erosion_numpy(img, |                      |                      |                              |                  |              | ksize=3):       |          |
| pad                              | = ksize              | //                   | 2                            |                  |              |                 |          |
| padded                           | =                    | np.pad(img,          |                              | pad,             | mode='edge') |                 |          |
| out                              | = np.zeros_like(img) |                      |                              |                  |              |                 |          |
| for                              | i in                 | range(img.shape[0]): |                              |                  |              |                 |          |
|                                  | for                  | j in                 | range(img.shape[1]):         |                  |              |                 |          |
|                                  |                      | region               | = padded[i:i+ksize,          |                  |              | j:j+ksize]      |          |
|                                  |                      | out[i,               | j]                           | = np.min(region) |              |                 |          |
| return                           | out                  |                      |                              |                  |              |                 |          |
| Example                          |                      | usage:               |                              |                  |              |                 |          |
| eroded_gray_np                   |                      | =                    | grayscale_erosion_numpy(img, |                  |              |                 | ksize=3) |
show_images([img, eroded_gray_np], ["Grayscale image ốgc", "Grayscale erosion (
NumPy)"])
| 8.3 | Erosion |     | with | OpenCV |     |     |     |
| --- | ------- | --- | ---- | ------ | --- | --- | --- |
kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (3, 3))
| eroded_gray |     | = cv2.erode(img,       |     |     | kernel, | iterations=1) |               |
| ----------- | --- | ---------------------- | --- | --- | ------- | ------------- | ------------- |
| eroded_bin  | =   | cv2.erode(binary_otsu, |     |     |         | kernel,       | iterations=1) |
show_images(
| [img, | eroded_gray, |     |     | binary_otsu, |     | eroded_bin], |     |
| ----- | ------------ | --- | --- | ------------ | --- | ------------ | --- |
["Grayscale image", "Erosion on grayscale image", "Binary image", "Erosion on
| binary       | image"], |     |     |     |     |     |     |
| ------------ | -------- | --- | --- | --- | --- | --- | --- |
| figsize=(16, |          |     | 8)  |     |     |     |     |
)
5

| 8.4 | Result | Analysis |     |     |     |     |     |     |     |
| --- | ------ | -------- | --- | --- | --- | --- | --- | --- | --- |
On grayscale images. Small bright regions or thin details are weakened, bright bound-
| aries | shrink | inward, | and | dark | regions | tend | to expand | relatively. |     |
| ----- | ------ | ------- | --- | ---- | ------- | ---- | --------- | ----------- | --- |
On binary images. White objects become smaller, thin branches or spikes may disap-
pear, and if the kernel is too large, small objects may vanish completely.
In cell images, erosion can remove small noisy protrusions along boundaries, but if used
too aggressively it can distort the true area and shape of the cells.
| Extended |     | Exercises |     | after | Erosion |     |     |     |     |
| -------- | --- | --------- | --- | ----- | ------- | --- | --- | --- | --- |
1. Try erosion with kernels (3,3), (5,5), and (7,7), then compare the object area
after processing.
2. Try both square and ellipse kernels on a cell image, and comment on which one
|     | preserves |     | the boundary |     | more | naturally. |     |     |     |
| --- | --------- | --- | ------------ | --- | ---- | ---------- | --- | --- | --- |
3. For an image where two cells are connected by a thin neck, increase the number
|     | of  | iterations |     | and observe |     | when the | two | objects | separate. |
| --- | --- | ---------- | --- | ----------- | --- | -------- | --- | ------- | --------- |
9 Dilation
9.1 Meaning
Dilation làm mở rộng vùng sáng trong binary images, hoặc làm tăng cường sáng cục bộ
| trong | ảnh         | xám. Nó  | có     | xu hướng: |     |     |     |     |     |
| ----- | ----------- | -------- | ------ | --------- | --- | --- | --- | --- | --- |
| •     | thicken     | objects, |        |           |     |     |     |     |     |
| •     | fill narrow | gaps,    |        |           |     |     |     |     |     |
| •     | connect     | nearby   | bright | regions,  |     |     |     |     |     |
• fill small holes if they are suﬀiciently small relative to the kernel.
In medical images, dilation can help restore slightly broken objects after thresholding,
connect fragmented lesion or tissue regions, and make thin structures more evident before
region analysis.
| 9.2 | Grayscale |     | Dilation: |     |     | Algorithmic |     | Interpretation |     |
| --- | --------- | --- | --------- | --- | --- | ----------- | --- | -------------- | --- |
At each position, consider the neighborhood defined by the kernel; the output is the max-
| imum                              | value | in that                 | region.              |      |              |           |     |     |     |
| --------------------------------- | ----- | ----------------------- | -------------------- | ---- | ------------ | --------- | --- | --- | --- |
| NumPy                             |       | implementation:         |                      |      |              |           |     |     |     |
| def grayscale_dilation_numpy(img, |       |                         |                      |      |              | ksize=3): |     |     |     |
| pad                               | =     | ksize                   | // 2                 |      |              |           |     |     |     |
| padded                            |       | = np.pad(img,           |                      | pad, | mode='edge') |           |     |     |     |
| out                               | =     | np.zeros_like(img)      |                      |      |              |           |     |     |     |
| for                               | i     | in range(img.shape[0]): |                      |      |              |           |     |     |     |
|                                   | for   | j in                    | range(img.shape[1]): |      |              |           |     |     |     |
6

|                 |     | region | =                               | padded[i:i+ksize, |     | j:j+ksize] |          |
| --------------- | --- | ------ | ------------------------------- | ----------------- | --- | ---------- | -------- |
|                 |     | out[i, | j]                              | = np.max(region)  |     |            |          |
| return          |     | out    |                                 |                   |     |            |          |
| Example         |     | usage: |                                 |                   |     |            |          |
| dilated_gray_np |     |        | = grayscale_dilation_numpy(img, |                   |     |            | ksize=3) |
show_images([img, dilated_gray_np], ["Grayscale image ốgc", "Grayscale dilation (
NumPy)"])
| 9.3 | Dilation |     | with | OpenCV |     |     |     |
| --- | -------- | --- | ---- | ------ | --- | --- | --- |
kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (3, 3))
| dilated_gray |     | =                         | cv2.dilate(img, |     | kernel, | iterations=1) |               |
| ------------ | --- | ------------------------- | --------------- | --- | ------- | ------------- | ------------- |
| dilated_bin  |     | = cv2.dilate(binary_otsu, |                 |     |         | kernel,       | iterations=1) |
show_images(
| [img, |     | dilated_gray, |     | binary_otsu, |     | dilated_bin], |     |
| ----- | --- | ------------- | --- | ------------ | --- | ------------- | --- |
["Grayscale image", "Dilation on grayscale image", "Binary image", "Dilation
| on           | binary | image"], |     |     |     |     |     |
| ------------ | ------ | -------- | --- | --- | --- | --- | --- |
| figsize=(16, |        |          | 8)  |     |     |     |     |
)
| 9.4 | Result |     | Analysis |     |     |     |     |
| --- | ------ | --- | -------- | --- | --- | --- | --- |
On grayscale images. Bright regions spread outward, small dark valleys may be filled,
| and bright |     | boundaries |     | may become | thicker. |     |     |
| ---------- | --- | ---------- | --- | ---------- | -------- | --- | --- |
On binary images. White objects expand, small gaps are filled, and nearby objects may
merge.
In cell images, dilation may be helpful when boundaries are slightly broken, but it can
| also cause |     | nearby    | cells | to merge | into one | region. |     |
| ---------- | --- | --------- | ----- | -------- | -------- | ------- | --- |
| Extended   |     | Exercises |       | after    | Dilation |         |     |
1. Apply dilation to an image with narrow holes or broken boundaries, and observe
|     | how | regions | become | connected. |     |     |     |
| --- | --- | ------- | ------ | ---------- | --- | --- | --- |
2. Increase iterations from 1 to 3 and analyze when separate objects start to
merge.
3. Erosionmpare dilation on a grayscale image and on a thresholded image, and
|     | explain | the | difference | in  | shape | control. |     |
| --- | ------- | --- | ---------- | --- | ----- | -------- | --- |
10 Opening
| 10.1 | Definition |     |     |         |     |           |            |
| ---- | ---------- | --- | --- | ------- | --- | --------- | ---------- |
|      |            |     |     | Opening |     | = Erosion | → Dilation |
7

That is, erosion is applied first to remove small outward protrusions, then dilation is
| used to  | approximately |            |          | restore | the main       | structure | size. |     |
| -------- | ------------- | ---------- | -------- | ------- | -------------- | --------- | ----- | --- |
| 10.2     | Intuitive     |            | Meaning  |         |                |           |       |     |
| Opening  | is commonly   |            | used     | to:     |                |           |       |     |
| • remove |               | small      | bright   | spots,  |                |           |       |     |
| • smooth |               | protruding |          | spikes  | on boundaries, |           |       |     |
| • remove |               | small      | unwanted |         | objects,       |           |       |     |
• preserve the main structure if it is suﬀiciently large relative to the kernel.
This operation is very useful for cell images or lesion regions with spiky, rough bound-
aries.
| 10.3 | Opening |     | Step | by  | Step |     |     |     |
| ---- | ------- | --- | ---- | --- | ---- | --- | --- | --- |
kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
| # Manual      | step-by-step           |      |                  | implementation |         |                       |     |     |
| ------------- | ---------------------- | ---- | ---------------- | -------------- | ------- | --------------------- | --- | --- |
| temp =        | cv2.erode(binary_otsu, |      |                  |                | kernel, | iterations=1)         |     |     |
| opened_manual |                        | =    | cv2.dilate(temp, |                |         | kernel, iterations=1) |     |     |
| # ọGi         | ựtrc                   | ếtip |                  |                |         |                       |     |     |
opened_cv = cv2.morphologyEx(binary_otsu, cv2.MORPH_OPEN, kernel)
show_images(
| [binary_otsu, |     |     | temp, | opened_manual, |     | opened_cv], |     |     |
| ------------- | --- | --- | ----- | -------------- | --- | ----------- | --- | --- |
["Binary image", "After erosion", "Opening (manual)", "Opening (OpenCV)"],
| figsize=(16, |     |     | 8)  |     |     |     |     |     |
| ------------ | --- | --- | --- | --- | --- | --- | --- | --- |
)
| Có          | thể áp | dụng                    | cho | ảnh xám: |     |                 |     |         |
| ----------- | ------ | ----------------------- | --- | -------- | --- | --------------- | --- | ------- |
| opened_gray |        | = cv2.morphologyEx(img, |     |          |     | cv2.MORPH_OPEN, |     | kernel) |
show_images([img, opened_gray], ["Grayscale image ốgc", "Opening on grayscale
image"])
| 10.4 | Result |     | Analysis |     |     |     |     |     |
| ---- | ------ | --- | -------- | --- | --- | --- | --- | --- |
Opening có tác dụng mạnh với small bright noise, small protrusions, small spikes along
object boundaries. Trên ảnh y tế và ảnh tế bào, mở thường giúp smooth contours, remove
false protrusions caused by noise, retain the main region more stably than erosion alone.
Tuy nhiên, if the kernel is too large, opening may remove thin structures that are actually
important.
8

| Extended |     | Exercises |     | after | Opening |     |     |
| -------- | --- | --------- | --- | ----- | ------- | --- | --- |
1. Trên ảnh tế bào có jagged edges, thử phép mở với kernel ellipse (3,3), (5,5),
(7,7).
2. Erosionmpare the image after opening with the image after erosion alone. Ex-
plain why opening is usually gentler than erosion when the goal is boundary
smoothing.
3. Find a case where opening removes an important structure and explain why.
11 Closing
| 11.1 | Definition |     |     |         |     |            |           |
| ---- | ---------- | --- | --- | ------- | --- | ---------- | --------- |
|      |            |     |     | Closing |     | = Dilation | → Erosion |
That is, dilation is applied first to fill small gaps or holes, then erosion is used to avoid
| excessive | expansion   |         | of the  | object.     |             |           |     |
| --------- | ----------- | ------- | ------- | ----------- | ----------- | --------- | --- |
| 11.2      | Intuitive   |         | Meaning |             |             |           |     |
| Closing   | is commonly |         | used    | to:         |             |           |     |
| • fill    | small       | dark    | holes   | inside      | bright      | objects,  |     |
| • connect |             | narrow  | breaks  | along       | boundaries, |           |     |
| • smooth  |             | small   | inward  | dents       | on the      | boundary, |     |
| • make    |             | objects | more    | continuous. |             |           |     |
Trong ảnh tế bào hoặc ảnh y tế, the segmented object region may contain small holes,
biên có thể bị nứt, hở; closing is very useful to fill and reconnect such regions.
| 11.3 | Closing |     | Step | by Step |     | and with | OpenCV |
| ---- | ------- | --- | ---- | ------- | --- | -------- | ------ |
kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
| temp =        | cv2.dilate(binary_otsu, |     |                 |     | kernel, | iterations=1) |     |
| ------------- | ----------------------- | --- | --------------- | --- | ------- | ------------- | --- |
| closed_manual |                         | =   | cv2.erode(temp, |     | kernel, | iterations=1) |     |
closed_cv = cv2.morphologyEx(binary_otsu, cv2.MORPH_CLOSE, kernel)
show_images(
| [binary_otsu, |     |     | temp, | closed_manual, |     | closed_cv], |     |
| ------------- | --- | --- | ----- | -------------- | --- | ----------- | --- |
["Binary image", "After dilation", "Closing (manual)", "Closing (OpenCV)"],
| figsize=(16, |     |     | 8)  |     |     |     |     |
| ------------ | --- | --- | --- | --- | --- | --- | --- |
)
| Áp  | dụng | trên | ảnh xám: |     |     |     |     |
| --- | ---- | ---- | -------- | --- | --- | --- | --- |
9

| closed_gray |     | =   | cv2.morphologyEx(img, |     |     |     | cv2.MORPH_CLOSE, |     |     | kernel) |     |     |
| ----------- | --- | --- | --------------------- | --- | --- | --- | ---------------- | --- | --- | ------- | --- | --- |
show_images([img, closed_gray], ["Grayscale image ốgc", "Closing on grayscale
image"])
| 11.4 | Result |     | Analysis |     |     |     |     |     |     |     |     |     |
| ---- | ------ | --- | -------- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
Closing đặc biệt hiệu quả khi the object contains small holes, the boundary has small cracks,
bright regions are nearly connected but still separated by a very narrow gap. So với mở,
opening tends to remove small bright details outside the object, còn closing tends to fill
small dark details inside the object. Trong ảnh y tế, if a segmentation mask is porous or
contains small holes, closing is often a good post-processing step.
| Extended |     | Exercises |     | after | Closing |     |     |     |     |     |     |     |
| -------- | --- | --------- | --- | ----- | ------- | --- | --- | --- | --- | --- | --- | --- |
1. Create a binary image containing one object with several small holes, apply
|     | closing, |     | and | comment | on  | the hole-filling |     | ability. |     |     |     |     |
| --- | -------- | --- | --- | ------- | --- | ---------------- | --- | -------- | --- | --- | --- | --- |
2. Erosionmpare closing with simple dilation for connecting narrow gaps.
3. Try square and ellipse kernels on a nearly circular object, and comment on the
|     | naturalness |       | of   | the    | resulting | boundary. |     |     |     |     |        |     |
| --- | ----------- | ----- | ---- | ------ | --------- | --------- | --- | --- | --- | --- | ------ | --- |
|     |             |       |      |        |           |           |     |     |     | →   |        | →   |
| 12  | Quy         | trình |      | thường |           | dùng:     |     | ảnh | xám |     | ngưỡng | hóa |
|     | xử          | lý    | hình | thái   |           |           |     |     |     |     |        |     |
Trong thực tế, nhất là với ảnh y tế và ảnh tế bào, một quy trình thường gặp là:
| 1.  | Đọc          | ảnh xám. |       |         |          |        |       |      |      |       |     |     |
| --- | ------------ | -------- | ----- | ------- | -------- | ------ | ----- | ---- | ---- | ----- | --- | --- |
| 2.  | Tăng         | chất     | lượng | tương   | phản     | nếu    | cần.  |      |      |       |     |     |
| 3.  | Thresholding |          | để    | tách    | vật thể. |        |       |      |      |       |     |     |
| 4.  | Áp dụng      | hình     | thái  | học     | để làm   | sạch   | mask. |      |      |       |     |     |
| 5.  | Đo diện      | tích,    | chu   | vi, đếm | đối      | tượng, | hoặc  | phân | đoạn | tiếp. |     |     |
Ví dụ:
| img =  | cv2.imread("cell_image.png", |              |           |     |           |     | cv2.IMREAD_GRAYSCALE) |     |     |     |     |     |
| ------ | ---------------------------- | ------------ | --------- | --- | --------- | --- | --------------------- | --- | --- | --- | --- | --- |
| # Step | 1:                           | light        | smoothing |     | if needed |     |                       |     |     |     |     |     |
| blur   | = cv2.GaussianBlur(img,      |              |           |     | (5,       | 5), | 0)                    |     |     |     |     |     |
| # Step | 2:                           | thresholding |           |     |           |     |                       |     |     |     |     |     |
_, binary = cv2.threshold(blur, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)
| # Step | 3:  | opening | to  | remove | small | bright |     | noise | / small | spurs |     |     |
| ------ | --- | ------- | --- | ------ | ----- | ------ | --- | ----- | ------- | ----- | --- | --- |
kernel_open = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (3, 3))
opened = cv2.morphologyEx(binary, cv2.MORPH_OPEN, kernel_open)
10

| # Step | 4: closing |     | to fill | small | holes | inside | the | object |     |     |
| ------ | ---------- | --- | ------- | ----- | ----- | ------ | --- | ------ | --- | --- |
kernel_close = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
cleaned = cv2.morphologyEx(opened, cv2.MORPH_CLOSE, kernel_close)
show_images(
| [img, | blur, | binary, |     | opened, | cleaned], |     |     |     |     |     |
| ----- | ----- | ------- | --- | ------- | --------- | --- | --- | --- | --- | --- |
["Grayscale image", "Smoothing", "Thresholding", "After Opening", "After
| Opening      |     | + Closing"], |     |     |     |     |     |     |     |     |
| ------------ | --- | ------------ | --- | --- | --- | --- | --- | --- | --- | --- |
| figsize=(18, |     | 8)           |     |     |     |     |     |     |     |     |
)
| 12.1 | Why | is this |     | order | reasonable? |     |     |     |     |     |
| ---- | --- | ------- | --- | ----- | ----------- | --- | --- | --- | --- | --- |
• Opening first: removes small bright details, tiny protrusions, and noise around
boundaries.
• Closing afterward: fills the small holes still remaining inside object regions.
Nếu làm ngược lại, closing trước có thể làm nhiễu sáng nhỏ dày lên; and then opening
may not remove it completely or may distort the boundary differently.
| 13 Application |     |     |     | Examples |     |     | with | Medical | and Cell | Im- |
| -------------- | --- | --- | --- | -------- | --- | --- | ---- | ------- | -------- | --- |
ages
| 13.1 | Cell | Images |     | with | Spiky | or  | Jagged | Boundaries |     |     |
| ---- | ---- | ------ | --- | ---- | ----- | --- | ------ | ---------- | --- | --- |
Saungưỡnghóa, tếbàocóthểcósmallprotrusionsalongtheboundary, irregularboundaries,
| small bright |     | particles | around  | them. | In       | that    | case:     |     |     |     |
| ------------ | --- | --------- | ------- | ----- | -------- | ------- | --------- | --- | --- | --- |
| • Opening    |     | giúp      | bỏ các  | gai   | nhỏ.     |         |           |     |     |     |
| • Erosion    |     | nhẹ       | giúp    | xem   | mức độ   | ổn định | của biên. |     |     |     |
| • Closing    |     | giúp      | lấp chỗ | lõm   | nhỏ hoặc | lỗ      | rỗ.       |     |     |     |
13.2 Images of Lesions or Anatomical Structures with Small Holes
Sau phân đoạn, mask có thể xuất hiện small holes inside the object region, broken bound-
aries, narrow gaps. Khi đó, Closing là lựa chọn tốt để làm đầy và làm liền.
| 13.3 | Images | with |     | Very | Close | Objects |     |     |     |     |
| ---- | ------ | ---- | --- | ---- | ----- | ------- | --- | --- | --- | --- |
Nếu cần giữ các đối tượng tách biệt thì avoid overly strong dilation or closing, và and
consider mild erosion first. Nếu cần gộp các phần rất gần thì use dilation or closing.
11

| 14        | Erosionmparison |             |     | of  | the | Operations |      |     |      |     |
| --------- | --------------- | ----------- | --- | --- | --- | ---------- | ---- | --- | ---- | --- |
| Operation |                 | Main effect |     |     |     | Useful     | when |     | Risk |     |
Erosion Shrinks bright regions Removes small spurs, Loses thin details
|     |     |     |     |     |     | separates | narrow |     |     |     |
| --- | --- | --- | --- | --- | --- | --------- | ------ | --- | --- | --- |
bridges
| Dilation |     | Expands | bright |     |     | Connects | broken   |     | Merges  | nearby |
| -------- | --- | ------- | ------ | --- | --- | -------- | -------- | --- | ------- | ------ |
|          |     | regions |        |     |     | regions, | thickens |     | objects |        |
objects
| Opening |     | Removes    | small   | bright |     | Small       | bright | noise, | Removes    |       |
| ------- | --- | ---------- | ------- | ------ | --- | ----------- | ------ | ------ | ---------- | ----- |
|         |     | details,   | smooths |        |     | spiky edges |        |        | genuinely  | small |
|         |     | boundaries | lồi     |        |     |             |        |        | structures |       |
Closing Fills small dark holes, Porous masks, cracked May merge
|     |      | connects | narrow | gaps |     | boundaries |     |         | nearby  | regions |
| --- | ---- | -------- | ------ | ---- | --- | ---------- | --- | ------- | ------- | ------- |
| 15  | Đoạn | mã tổng  | hợp    |      | để  | tự thay    |     | đổi thứ | tự phép | toán    |
img = cv2.imread("medical_or_cell_image.png", cv2.IMREAD_GRAYSCALE)
| blur = | cv2.GaussianBlur(img, |     |     | (5, 5), | 0)  |     |     |     |     |     |
| ------ | --------------------- | --- | --- | ------- | --- | --- | --- | --- | --- | --- |
_, binary = cv2.threshold(blur, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)
kernel3 = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (3, 3))
kernel5 = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
| erosion  | = cv2.erode(binary,        |     | kernel3, |          | iterations=1)    |               |     |          |     |     |
| -------- | -------------------------- | --- | -------- | -------- | ---------------- | ------------- | --- | -------- | --- | --- |
| dilation | = cv2.dilate(binary,       |     |          | kernel3, |                  | iterations=1) |     |          |     |     |
| opening  | = cv2.morphologyEx(binary, |     |          |          | cv2.MORPH_OPEN,  |               |     | kernel3) |     |     |
| closing  | = cv2.morphologyEx(binary, |     |          |          | cv2.MORPH_CLOSE, |               |     | kernel5) |     |     |
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
|     | "Opening | -> Closing", |     |     |     |     |     |     |     |     |
| --- | -------- | ------------ | --- | --- | --- | --- | --- | --- | --- | --- |
|     | "Closing | -> Opening"  |     |     |     |     |     |     |     |     |
],
| figsize=(20, |     | 10) |     |     |     |     |     |     |     |     |
| ------------ | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
)
12

| 16   |     | End-of-Lab |     | Exercises |     |                 |     |      |       |       |
| ---- | --- | ---------- | --- | --------- | --- | --------------- | --- | ---- | ----- | ----- |
| 16.1 |     | Exercise   | 1.  | Cleaning  |     | Cell Boundaries |     | with | Small | Spurs |
Given a thresholded cell image, many cells have jagged boundaries and small spurs.
Tasks:
1. Apply each operation separately: erosion, dilation, opening, closing.
2. Compare the results in terms of: boundary smoothness, preservation of overall shape,
|     | risk | of removing | true | details. |     |     |     |     |     |     |
| --- | ---- | ----------- | ---- | -------- | --- | --- | --- | --- | --- | --- |
3. Conclude which operation is most suitable for removing small spurs along the bound-
ary.
Analysis hint: opening is often more suitable than erosion alone because dilation after
| erosion |     | approximately | restores |         | the main | shape. |      |        |        |     |
| ------- | --- | ------------- | -------- | ------- | -------- | ------ | ---- | ------ | ------ | --- |
| 16.2    |     | Exercise      | 2.       | Filling | Small    | Holes  | in a | Lesion | Region |     |
Given a binary mask of a lesion region, there are many small black holes inside the white
region.
Tasks:
|     | 1. Apply | closing | with | three | different | kernel sizes. |     |     |     |     |
| --- | -------- | ------- | ---- | ----- | --------- | ------------- | --- | --- | --- | --- |
2. Compare hole-filling ability and the amount of outer-boundary distortion.
3. Explain why a larger kernel fills holes more effectively but may also change the overall
shape.
| 16.3 |            | Exercise   | 3.      | Comparing |         | Two Operation |     | Pipelines |     |     |
| ---- | ---------- | ---------- | ------- | --------- | ------- | ------------- | --- | --------- | --- | --- |
| Trên | cùng       | một binary | images, |           | hãy tạo | hai pipeline: |     |           |     |     |
|      | • Pipeline | A:         | Opening | ->        | Closing |               |     |           |     |     |
|      | • Pipeline | B:         | Closing | ->        | Opening |               |     |           |     |     |
Tasks:
|     | 1. Display | the | result | of each | step. |     |     |     |     |     |
| --- | ---------- | --- | ------ | ------- | ----- | --- | --- | --- | --- | --- |
2. So sánh: number of remaining noise points, number of remaining small holes, mức
|     | boundary | smoothness, |     | ability | to  | preserve object | size. |     |     |     |
| --- | -------- | ----------- | --- | ------- | --- | --------------- | ----- | --- | --- | --- |
3. Explain why the two pipelines produce different results even though both use opening
|     | and | closing. |     |     |     |     |     |     |     |     |
| --- | --- | -------- | --- | --- | --- | --- | --- | --- | --- | --- |
Gợi ý: the order of operations determines which details are removed first and which ones
| are | filled | first. |     |     |     |     |     |     |     |     |
| --- | ------ | ------ | --- | --- | --- | --- | --- | --- | --- | --- |
13

| 16.4 | Exercise |     | 4.  | Separating | Slightly |     | Touching |     | Cells |     |
| ---- | -------- | --- | --- | ---------- | -------- | --- | -------- | --- | ----- | --- |
Given a binary image containing several nearby cells, some pairs are connected by narrow
bridges.
Tasks:
1. Use erosion with multiple kernel sizes to try separating the cells.
|     | 2. Then    | use dilation |        | to approximately | restore |     | their size. |     |     |     |
| --- | ---------- | ------------ | ------ | ---------------- | ------- | --- | ----------- | --- | --- | --- |
|     | 3. Compare | the          | result | with opening.    |         |     |             |     |     |     |
4. Giảithíchtrườnghợpnàoopeninghiệuquảhơnchuỗitựthiếtkếerosion -> dilation,
và vì sao trên thực tế hai kết quả có thể giống hoặc khác nhau tùy tham số.
| 16.5 | Exercise |     | 5.  | Analyzing | the | Influence |     | of  | Kernel | Shape |
| ---- | -------- | --- | --- | --------- | --- | --------- | --- | --- | ------ | ----- |
Choose an image containing nearly round objects such as cells, red blood cells, white blood
| cells, | or nuclei. |     |     |     |     |     |     |     |     |     |
| ------ | ---------- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
Tasks:
|     | 1. Perform | opening    |         | and closing | with: |     |     |     |     |     |
| --- | ---------- | ---------- | ------- | ----------- | ----- | --- | --- | --- | --- | --- |
|     | •          | a square   | kernel, |             |       |     |     |     |     |     |
|     | •          | an ellipse | kernel, |             |       |     |     |     |     |     |
|     | •          | a cross    | kernel. |             |       |     |     |     |     |     |
2. So sánh: naturalness of the boundary, ability to preserve a nearly circular shape,
|     | effectiveness |     | in removing | noise | or filling | holes. |     |     |     |     |
| --- | ------------- | --- | ----------- | ----- | ---------- | ------ | --- | --- | --- | --- |
3. Explainwhy,insomemedicalimagingtasks,anellipsekernelisoftenmoreappropriate.
| 17  | Discussion |     |     | and Analysis |     | Questions |     |     |     |     |
| --- | ---------- | --- | --- | ------------ | --- | --------- | --- | --- | --- | --- |
1. Why is opening suitable for removing small bright outward protrusions, while closing
|     | is suitable | for | filling | small dark | holes | inside | objects? |     |     |     |
| --- | ----------- | --- | ------- | ---------- | ----- | ------ | -------- | --- | --- | --- |
2. In cell images, when can smoothing boundaries with morphology be harmful for
|     | biomedical | analysis? |     |     |     |     |     |     |     |     |
| --- | ---------- | --------- | --- | --- | --- | --- | --- | --- | --- | --- |
3. Why does the same operation produce a different effect when applied to grayscale
|     | images | versus | binary | images? |     |     |     |     |     |     |
| --- | ------ | ------ | ------ | ------- | --- | --- | --- | --- | --- | --- |
4. If the goal is cell counting, which pipeline would you choose to both clean noise and
|     | reduce | the risk | of  | two cells merging? |     |     |     |     |     |     |
| --- | ------ | -------- | --- | ------------------ | --- | --- | --- | --- | --- | --- |
5. When should you increase the kernel size, and when should you keep the kernel small
|     | but increase |     | the | number of iterations? |     |     |     |     |     |     |
| --- | ------------ | --- | --- | --------------------- | --- | --- | --- | --- | --- | --- |
14

18 Conclusion
From this lab, students should take away the following main ideas:
• Morphology is a very powerful tool for shape-based image processing.
• Erosion và giãn là hai phép cơ sở.
• Opening và đóng là các tổ hợp cực kỳ hữu ích trong tiền xử lý và hậu xử lý.
• Với ảnh y tế, ảnh tế bào, việc chọn loại ảnh xử lý, kiểu kernel, kích thước kernel, và
đặc biệt là thứ tự các phép toán có ảnh hưởng rất lớn đến chất lượng kết quả cuối
cùng.
15