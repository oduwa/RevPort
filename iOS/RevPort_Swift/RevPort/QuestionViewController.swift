//
//  QuestionViewController.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 22/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

class QuestionViewController: UIViewController {

    
    var questions = Array<PFObject>();
    var choices = Array<String>();
    var answers = Array<String>();
    var questionIndex : Int = 0;
    
    @IBOutlet weak var questionTextView: UITextView!
    @IBOutlet weak var optionTextViewA: UITextView!
    @IBOutlet weak var optionTextViewB: UITextView!
    @IBOutlet weak var optionTextViewC: UITextView!
    @IBOutlet weak var optionTextViewD: UITextView!
    
    @IBOutlet weak var optionButtonA: UIButton!
    @IBOutlet weak var optionButtonB: UIButton!
    @IBOutlet weak var optionButtonC: UIButton!
    @IBOutlet weak var optionButtonD: UIButton!
    
    @IBOutlet weak var prevButton: UIButton!
    @IBOutlet weak var nextButton: UIButton!
    @IBOutlet weak var doneButton: UIButton!
    
    
    override func viewDidLoad() {
        super.viewDidLoad()

        if(!self.questions.isEmpty){
            
            for question in self.questions{
                self.choices.append("");
            }
            
            loadQuestionForIndex(questionIndex);
        }
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    
    // MARK: - Helpers
    func loadQuestionForIndex(index : Int){
        /* Get question and options */
        var question = self.questions[index];
        var options : Array<String> = question["options"] as Array<String>;
        
        /* Update views with question details */
        self.questionTextView.text = question["questionText"] as String;
        self.optionTextViewA.text = options[0] as String;
        self.optionTextViewB.text = options[1] as String;
        self.optionTextViewC.text = options[2] as String;
        self.optionTextViewD.text = options[3] as String;
        
        /* Highlight option if already answered */
        if(self.choices[index] != ""){
            if(self.choices[index] == "A"){
                optionAPressed(optionButtonA);
            }
            else if(self.choices[index] == "B"){
                optionBPressed(optionButtonB);
            }
            else if(self.choices[index] == "C"){
                optionCPressed(optionButtonC);
            }
            else if(self.choices[index] == "D"){
                optionDPressed(optionButtonD);
            }
        }
    }
    
    
    // MARK: - IBActions and Selectors
    @IBAction func prevButtonPressed(sender: AnyObject) {
        if(questionIndex-1 >= 0){
            /* Reset option colours */
            self.optionTextViewA.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
            self.optionTextViewB.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
            self.optionTextViewC.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
            self.optionTextViewD.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
            
            /* Load question */
            loadQuestionForIndex(--questionIndex);
        }
    }
    
    @IBAction func nextButtonPressed(sender: AnyObject) {
        if(questionIndex+1 < self.questions.count){
            /* Reset option colours */
            self.optionTextViewA.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
            self.optionTextViewB.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
            self.optionTextViewC.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
            self.optionTextViewD.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
            
            /* Load question */
            loadQuestionForIndex(++questionIndex);
        }
    }

    @IBAction func optionAPressed(sender: AnyObject) {
        self.choices[questionIndex] = "A";
        if(self.answers.count <= questionIndex){
            self.answers.append(self.optionTextViewA.text);
        }
        else{
            self.answers[questionIndex] = self.optionTextViewA.text;
        }
        self.optionTextViewA.backgroundColor = UIColor.greenColor();
        self.optionTextViewB.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
        self.optionTextViewC.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
        self.optionTextViewD.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
    }
    @IBAction func optionBPressed(sender: AnyObject) {
        self.choices[questionIndex] = "B";
        if(self.answers.count <= questionIndex){
            self.answers.append(self.optionTextViewB.text);
        }
        else{
            self.answers[questionIndex] = self.optionTextViewB.text;
        }
        self.optionTextViewA.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
        self.optionTextViewB.backgroundColor = UIColor.greenColor();
        self.optionTextViewC.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
        self.optionTextViewD.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
    }
    @IBAction func optionCPressed(sender: AnyObject) {
        self.choices[questionIndex] = "C";
        if(self.answers.count <= questionIndex){
            self.answers.append(self.optionTextViewC.text);
        }
        else{
            self.answers[questionIndex] = self.optionTextViewC.text;
        }
        self.optionTextViewA.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
        self.optionTextViewB.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
        self.optionTextViewC.backgroundColor = UIColor.greenColor();
        self.optionTextViewD.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
    }
    @IBAction func optionDPressed(sender: AnyObject) {
        self.choices[questionIndex] = "D";
        if(self.answers.count <= questionIndex){
            self.answers.append(self.optionTextViewD.text);
        }
        else{
            self.answers[questionIndex] = self.optionTextViewD.text;
        }
        self.optionTextViewA.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
        self.optionTextViewB.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
        self.optionTextViewC.backgroundColor = UIColor(red: 87.0/255.0, green: 220.0/255.0, blue: 255.0/255.0, alpha: 1.0);
        self.optionTextViewD.backgroundColor = UIColor.greenColor();
    }
    
    @IBAction func submitButtonPressed(sender: AnyObject) {
        if(self.answers.count == self.questions.count){
            /* Count correct answers */
            var i = 0;
            var numberCorrect = 0;
            for answer in answers {
                var correctAnswer = self.questions[i]["correctAnswer"] as String;
                if(answer == correctAnswer){
                    numberCorrect++;
                }
                i++;
            }
            
            /* Calculate score */
            var score = (Double(numberCorrect)/Double(self.questions.count)) * 100.0;
            score = AppUtils.sharedInstance.roundToDecimalPlaces(score, decimalPlaces: 2);
            
            /* display score */
            AppUtils.sharedInstance.makeAlertView("RevPort", message: "You scored \(score)%", action: "OK", sender: self);
            
            /* Send notification to test list controller to dismiss question controller and show answer controller */
            var info = [NSString : NSArray]();
            info["choices"] = self.choices;
            info["answers"] = self.answers;
            NSNotificationCenter.defaultCenter().postNotificationName("ShowAnswersNotif", object: nil, userInfo: info);
        }
        else{
            AppUtils.sharedInstance.makeAlertView("RevPort", message: "Please answer all questions before you submit", action: "OK", sender: self);
        }
    }
    /*
    // MARK: - Navigation
    
    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
    }
    */

}
