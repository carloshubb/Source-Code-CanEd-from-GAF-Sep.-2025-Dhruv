// import 'package:proxima_study/Controller/HomeController.dart';
// import 'package:proxima_study/pages/home_page.dart';
// import 'package:proxima_study/pages/search_detail_page.dart';
// import 'package:flutter/material.dart';
// import 'package:fluttertoast/fluttertoast.dart';
// import '../consts/constFileLink.dart';
//
// class NavigationPage extends StatelessWidget{
//   NavigationPage({Key? key}) : super(key: key);
//
//   @override
//
//   var controller = Get.put(HomeController());
//   var pages =[
//     HomePage(),
//     SearchDetailPage()
//   ];
//   Widget build(BuildContext context) {
//     return Scaffold(
//       body: Column(
//         children: [
//           Obx(() => Expanded(
//               child: pages.elementAt(controller.currentNavIndex.value)
//           )
//           )
//         ],
//       ),
//       bottomNavigationBar: Obx(() =>
//           BottomNavigationBar(
//             currentIndex: controller.currentNavIndex.value,
//             type: BottomNavigationBarType.fixed,
//             backgroundColor: Colors.white,
//             selectedLabelStyle: const TextStyle(fontFamily: semiBold),
//             items: const [
//               BottomNavigationBarItem( icon: Icon(Icons.home), label: "Home"),
//               BottomNavigationBarItem( icon: Icon(Icons.search), label: "Search"),
//             ],
//             onTap: (value) {
//               controller.currentNavIndex.value = value;
//
//             },
//           ),
//       ),
//     );
//   }
// }
