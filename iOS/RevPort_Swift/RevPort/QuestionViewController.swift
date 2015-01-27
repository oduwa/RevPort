//
//  QuestionViewController.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 22/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

class QuestionViewController: UIViewController {

    var test : PFObject!
    var questions = Array<PFObject>();
    var choices = Array<String>();
    var answers = Array<String>();
    var questionIndex : Int = 0;
    var isGradeable : Bool = false;
    
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
    @IBOutlet weak var quitButton: UIButton!
    
    
    var activityIndicator : UIActivityIndicatorView!;
    
    override func viewDidLoad() {
        super.viewDidLoad()

        if(!self.questions.isEmpty){
            
            for question in self.questions{
                self.choices.append("");
            }
            
            loadQuestionForIndex(questionIndex);
        }
        
        if(self.isGradeable){
            self.quitButton.hidden = true;
        }
        
        /* Activity Indicator */
        activityIndicator = UIActivityIndicatorView(activityIndicatorStyle: UIActivityIndicatorViewStyle.Gray);
        activityIndicator.center = self.view.center;
        activityIndicator.hidesWhenStopped = true;
        self.view.addSubview(activityIndicator);
        activityIndicator.hidden = true;
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
            activityIndicator.startAnimating();
            
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
            var mark = (Double(numberCorrect)/Double(self.questions.count)) * 100.0;
            mark = AppUtils.sharedInstance.roundToDecimalPlaces(mark, decimalPlaces: 2);
            
            
            /* Record score if necessary */
            var currentUsername = PFUser.currentUser().username;
            var attempters = test["attempters"] as Array<String>;
            var isGradeable = test["gradeable"] as Bool;
            var alreadyAttempted = false;
            
            // Check if user already took test
            if(contains(attempters, currentUsername)){
                alreadyAttempted = true;
            }
            
            // save new score if user has never done this test before, gradeable or not
            if(!alreadyAttempted){
                // Add as attempted
                attempters.append(currentUsername);
                test["attempters"] = attempters;
                test.save();
                
                // save score
                var score = PFObject(className:"Score");
                score["username"] = currentUsername;
                score["mark"] = mark;
                score["scoreModule"] = test["testModule"] as String;
                score["scoreTitle"] = test["testTitle"] as String;
                score.save();
                
                // add score to test's relation
                var relation = test.relationForKey("scores");
                relation.addObject(score);
                test.save();
            }
            // if user HAS taken the test and its NOT a gradeable test update their existing score
            else if(!isGradeable && alreadyAttempted){
                // Get users previous score
                var query = PFQuery(className:"Score")
                query.whereKey("username", equalTo:currentUsername)
                query.whereKey("scoreModule", equalTo:test["testModule"] as String)
                query.whereKey("scoreTitle", equalTo:test["testTitle"] as String)
                var score = query.getFirstObject();
                
                // update the users score
                score["mark"] = mark;
                score.save();
            }
            
            
            /* Record activity */
            var newActivity = PFObject(className:"Activity");
            var testModule = test["testModule"] as String;
            var testName = test["testTitle"] as String;
            var activityMessage = "completed the test \"\(testName)\" for \(testModule). Scored \(mark)%";
            newActivity["activityMessage"] = activityMessage;
            newActivity.saveInBackgroundWithBlock { (succeeded, error) -> Void in
                if(succeeded){
                    var activityRelation = PFUser.currentUser().relationForKey("activities");
                    activityRelation.addObject(newActivity);
                    PFUser.currentUser().saveInBackgroundWithBlock({ (succeeded, error) -> Void in
                        if(error == nil){
                            AppUtils.sharedInstance.cachedActivities.removeAll(keepCapacity: true);
                        }
                    })
                }
                else{
                    // nothing
                }
            }
            
            
            activityIndicator.stopAnimating();
            
            /* display score */
            AppUtils.sharedInstance.makeAlertView("RevPort", message: "You scored \(mark)%", action: "OK", sender: self);
            
            
            /* Send notification to test list controller to dismiss question controller, refresh test list controller and show answer controller */
            var info = [NSString : NSArray]();
            info["choices"] = self.choices;
            info["answers"] = self.answers;
            NSNotificationCenter.defaultCenter().postNotificationName("ShowAnswersNotif", object: nil, userInfo: info);
        }
        else{
            AppUtils.sharedInstance.makeAlertView("RevPort", message: "Please answer all questions before you submit", action: "OK", sender: self);
        }
    }
    
    @IBAction func quitButtonPressed(sender: AnyObject) {
        self.dismissViewControllerAnimated(true, completion: nil);
    }
    
    override func prefersStatusBarHidden() -> Bool {
        return true;
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
