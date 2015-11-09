package com.cassiano.sketcher;

/**
 * Created by Cassiano on 11/9/2014.
 */
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.BitmapShader;
import android.graphics.BlurMaskFilter;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.ColorFilter;
import android.graphics.Paint;
import android.graphics.Path;
import android.graphics.PathEffect;
import android.graphics.PorterDuff;
import android.graphics.PorterDuffColorFilter;
import android.graphics.Rect;
import android.graphics.Shader;
import android.util.AttributeSet;
import android.util.Base64;
import android.view.MotionEvent;
import android.view.View;

import java.io.ByteArrayOutputStream;
import java.util.ArrayList;
import java.util.List;

public class DrawingView extends View {

    //drawing path
    private Path drawPath;
    //drawing and canvas paint
    private Paint drawPaint, canvasPaint;
    //initial color
    private int paintColor = 0x66000000;
    //canvas
    private Canvas drawCanvas;
    //canvas bitmap
    private Bitmap canvasBitmap;

    //pen size
    private int penSize = 10;
    Context cont;

    //Brush
    private Bitmap brush;

    public DrawingView(Context context, AttributeSet attrs){
        super(context, attrs);
        cont = context;
        setupDrawing();
    }

    private void setupDrawing(){
        //get drawing area setup for interaction
        drawPath = new Path();
        drawPaint = new Paint();
        drawPaint.setColor(paintColor);

        //Line settings
        drawPaint.setAntiAlias(true);
        drawPaint.setStrokeWidth(penSize);
        drawPaint.setStyle(Paint.Style.STROKE);

        //drawPaint.setStyle(Paint.Style.FILL);

        //drawPaint.setStrokeJoin(Paint.Join.ROUND);
        drawPaint.setStrokeJoin(Paint.Join.MITER);

        //drawPaint.setStrokeCap(Paint.Cap.ROUND);
        drawPaint.setStrokeCap(Paint.Cap.SQUARE);
        drawPaint.setMaskFilter(new BlurMaskFilter(5, BlurMaskFilter.Blur.NORMAL));
        canvasPaint = new Paint(Paint.DITHER_FLAG);
        canvasPaint.setColor(Color.WHITE);
    }

    public void UpdatePen(int selected){
        //get drawing area setup for interaction
        drawPath = new Path();
        drawPaint = new Paint();
        int alpha = 255;
        penSize = SketcherDriver.getPenSize();
        drawPaint.setAntiAlias(true);
        drawPaint.setStrokeWidth(penSize);
        int color = Color.WHITE;
        switch (selected){
            //Pencil
            case 0:
                drawPaint.setStyle(Paint.Style.STROKE);
                drawPaint.setStrokeJoin(Paint.Join.ROUND);
                drawPaint.setStrokeCap(Paint.Cap.ROUND);
                alpha = 255/2;
                color = Color.argb(alpha,SketcherDriver.getPenRed(), SketcherDriver.getPenGreen(), SketcherDriver.getPenBlue());
                drawPaint.setColor(color);
                break;
            //Pen
            case 1:
                drawPaint.setStyle(Paint.Style.STROKE);
                drawPaint.setStrokeJoin(Paint.Join.ROUND);
                drawPaint.setStrokeCap(Paint.Cap.ROUND);
                alpha = 255;
                color = Color.argb(alpha,SketcherDriver.getPenRed(), SketcherDriver.getPenGreen(), SketcherDriver.getPenBlue());
                drawPaint.setColor(color);
                break;
            //Marker
            case 2:
                drawPaint.setStyle(Paint.Style.STROKE);
                drawPaint.setStrokeJoin(Paint.Join.MITER);
                drawPaint.setStrokeCap(Paint.Cap.BUTT);
                alpha = 255/2;
                color = Color.argb(alpha,SketcherDriver.getPenRed(), SketcherDriver.getPenGreen(), SketcherDriver.getPenBlue());
                drawPaint.setColorFilter(new PorterDuffColorFilter(color, PorterDuff.Mode.MULTIPLY));
                drawPaint.setColor(color);
                break;
            //Polygon
            case 3:
                drawPaint.setStyle(Paint.Style.FILL);
                drawPaint.setStrokeJoin(Paint.Join.ROUND);
                drawPaint.setStrokeCap(Paint.Cap.ROUND);
                alpha = 255;
                color = Color.argb(alpha,SketcherDriver.getPenRed(), SketcherDriver.getPenGreen(), SketcherDriver.getPenBlue());
                drawPaint.setColor(color);
                break;
        }

        //Line settings

        canvasPaint = new Paint(Paint.DITHER_FLAG);

    }

    @Override
    protected void onSizeChanged(int w, int h, int oldw, int oldh) {
        super.onSizeChanged(w, h, oldw, oldh);

        canvasBitmap = Bitmap.createBitmap(w, h, Bitmap.Config.ARGB_8888);
        canvasBitmap.eraseColor(Color.WHITE);
        drawCanvas = new Canvas(canvasBitmap);
    }

    @Override
    protected void onDraw(Canvas canvas) {
        super.onDraw(canvas);
        canvas.drawBitmap(canvasBitmap, 0, 0, canvasPaint);
        canvas.drawPath(drawPath, drawPaint);

    }

    @Override
    public boolean onTouchEvent(MotionEvent event) {
        //detect user touch
        if(SketcherDriver.windowState==0) {
            float touchX = event.getX();
            float touchY = event.getY();

            switch (event.getAction()) {
                case MotionEvent.ACTION_DOWN:
                    drawPath.moveTo(touchX, touchY);
                    break;
                case MotionEvent.ACTION_MOVE:
                    drawPath.lineTo(touchX, touchY);
                    invalidate();
                    break;
                case MotionEvent.ACTION_UP:
                    drawCanvas.drawPath(drawPath, drawPaint);
                    drawPath.reset();
                    break;
                default:
                    return false;
            }
        }
        invalidate();
        return true;
    }

    public Bitmap getBitmap(){
        return canvasBitmap;
    }

    public String getEncodedBitmap(){
        Bitmap bitmap = canvasBitmap;
        ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
        bitmap.compress(Bitmap.CompressFormat.PNG, 100, byteArrayOutputStream);
        byte[] byteArray = byteArrayOutputStream .toByteArray();
        String encoded = Base64.encodeToString(byteArray, Base64.DEFAULT);
        return encoded;
    }
}
