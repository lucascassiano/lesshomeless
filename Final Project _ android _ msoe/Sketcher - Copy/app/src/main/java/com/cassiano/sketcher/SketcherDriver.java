package com.cassiano.sketcher;

/**
 * Created by Cassiano on 11/10/2014.
 */
public class SketcherDriver {
    static public int windowState = 0;
    private static int penSize = 2;

    private static int penRed = 0;
    private static int penGreen = 0;
    private static int penBlue =0;
    private static int penAlpha = 255;

    private static int selectedBrush =0;

    private static int selectedPen=0;

    public static String getUser_code() {
        return user_code;
    }

    public static void setUser_code(String user_code) {
        SketcherDriver.user_code = user_code;
    }

    private static String user_code;

    public static int getWindowState() {
        return windowState;
    }

    public static void setWindowState(int windowState) {
        SketcherDriver.windowState = windowState;
    }

    public static int getPenSize() {
        return penSize;
    }

    public static void setPenSize(int penSize) {
        SketcherDriver.penSize = penSize;
    }

    public static int getPenRed() {
        return penRed;
    }

    public static void setPenRed(int penRed) {
        SketcherDriver.penRed = penRed;
    }

    public static int getPenGreen() {
        return penGreen;
    }

    public static void setPenGreen(int penGreen) {
        SketcherDriver.penGreen = penGreen;
    }

    public static int getPenBlue() {
        return penBlue;
    }

    public static void setPenBlue(int penBlue) {
        SketcherDriver.penBlue = penBlue;
    }

    public static int getPenAlpha() {
        return penAlpha;
    }

    public static void setPenAlpha(int penAlpha) {
        SketcherDriver.penAlpha = penAlpha;
    }

    public static int getSelectedBrush() {
        return selectedBrush;
    }

    public static void setSelectedBrush(int selectedBrush) {
        SketcherDriver.selectedBrush = selectedBrush;
    }

    public static int getSelectedPen() {
        return selectedPen;
    }

    public static void setSelectedPen(int selectedPen) {
        SketcherDriver.selectedPen = selectedPen;
    }
}
