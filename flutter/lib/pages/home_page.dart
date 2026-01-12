import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:webview_flutter/webview_flutter.dart';

import 'package:proxima_study/consts/constFileLink.dart';
import 'package:proxima_study/pages/widgets/overlay_widget.dart';
import 'package:proxima_study/services/service.dart';

class HomePage extends StatefulWidget {
  const HomePage({Key? key}) : super(key: key);

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  late final WebViewController _controller;

  @override
  void initState() {
    super.initState();

    _controller = WebViewController()
      ..setJavaScriptMode(JavaScriptMode.unrestricted)
      ..setNavigationDelegate(
        NavigationDelegate(
          onNavigationRequest: (NavigationRequest request) {
            print('Allowing navigation to: ${request.url}');
            return NavigationDecision.navigate;
          },
          onPageStarted: (String url) {
            print('Page started loading: $url');
            overlayWidget();
          },
          onPageFinished: (String url) {
            print('Page finished loading: $url');
          },
        ),
      )
      ..loadRequest(Uri.parse('https://xelentcaned.shop'));
  }

  @override
  Widget build(BuildContext context) {
    final serviceController = Get.find<Service>();

    return WillPopScope(
      onWillPop: () async {
        bool isConfirmed = await serviceController.showConfirmationDialog("Do you want to close this app?");
        return isConfirmed;
      },
      child: Scaffold(
        resizeToAvoidBottomInset: true,
        body: SafeArea(
          child: WebViewWidget(controller: _controller),
        ),
      ),
    );
  }
}