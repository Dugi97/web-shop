// $(document).ready(function() {
//     $("#add").click(function() {
//         var lastField = $("#buildyourform div:last");
//         var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
//         var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
//         fieldWrapper.data("idx", intId);
//         var fName = $("<input type=\"number\" name='qty_"+intId+"' class=\"form-control\" />");
//         var fType = $("" +
//             "<select class=\"form-control\" name='size_"+intId+"'>" +
//             "<option value=\"S\">S</option>" +
//             "<option value=\"M\">M</option>" +
//             "<option value=\"L\">L</option>" +
//             "<option value=\"XL\">XL</option>" +
//             "<option value=\"XXL\">XXL</option>" +
//             "<option value=\"32\">32</option>" +
//             "<option value=\"33\">33</option>" +
//             "<option value=\"34\">34</option>" +
//             "<option value=\"35\">35</option>" +
//             "<option value=\"36\">36</option>" +
//             "<option value=\"37\">37</option>" +
//             "<option value=\"38\">38</option>" +
//             "<option value=\"39\">39</option>" +
//             "<option value=\"40\">40</option>" +
//             "<option value=\"41\">41</option>" +
//             "<option value=\"42\">42</option>" +
//             "<option value=\"43\">43</option>" +
//             "<option value=\"44\">44</option>" +
//             "<option value=\"45\">45</option>" +
//             "<option value=\"46\">46</option>" +
//             "</select>");
//         var removeButton = $("<button type=\"button\" class=\"btn btn-success\">-</button>");
//         removeButton.click(function() {
//             $(this).parent().remove();
//         });
//         fieldWrapper.append(fName);
//         fieldWrapper.append(fType);
//         fieldWrapper.append(removeButton);
//         $("#buildyourform").append(fieldWrapper);
//     });
// });