import 'package:flutter/material.dart';

import '../../consts/constFileLink.dart';

Widget overlayWidget(){
  return Container(
    color: Colors.black.withOpacity(0.6),
    alignment: Alignment.center,
    child: CircularProgressIndicator(
      valueColor: AlwaysStoppedAnimation(const Color(0xFFF0094D4)),
    ),
  );
}