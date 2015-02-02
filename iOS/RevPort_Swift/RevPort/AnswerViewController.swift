//
//  AnswerViewController.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 24/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

class AnswerViewController: UIViewController {

    var questions = Array<PFObject>();
    var choices = Array<String>();
    var answers = Array<String>();
    var questionIndex : Int = 0;
    
    @IBOutlet weak var questionTextView: UITextView!
    @IBOutlet weak var optionTextViewA: UITextView!
    @IBOutlet weak var optionTextViewB: UITextView!
    @IBOutlet weak var optionTextViewC: UITextView!
    @IBOutlet weak var optionTextViewD: UITextView!

    @IBOutlet weak var prevButton: UIButton!
    @IBOutlet weak var nextButton: UIButton!
    @IBOutlet weak var doneButton: UIButton!
    
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        if(!self.questions.isEmpty){
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
        var correctAnswer = question["correctAnswer"] as String;
        var options : Array<String> = question["options"] as Array<String>;
        
        /* Update views with question details */
        self.questionTextView.text = question["questionText"] as String;
        self.optionTextViewA.text = options[0] as String;
        self.optionTextViewB.text = options[1] as String;
        self.optionTextViewC.text = options[2] as String;
        self.optionTextViewD.text = options[3] as String;
        
        /* Highlight option user selected */
        if(self.choices[index] != ""){
            if(self.choices[index] == "A"){
                self.optionTextViewA.backgroundColor = UIColor.redColor();
            }
            else if(self.choices[index] == "B"){
                self.optionTextViewB.backgroundColor = UIColor.redColor();
            }
            else if(self.choices[index] == "C"){
                self.optionTextViewC.backgroundColor = UIColor.redColor();
            }
            else if(self.choices[index] == "D"){
                self.optionTextViewD.backgroundColor = UIColor.redColor();
            }
        }
        
        /* Highlight correct answer */
        if(options[0] == correctAnswer){
            self.optionTextViewA.backgroundColor = UIColor.greenColor();
        }
        else if(options[1] == correctAnswer){
            self.optionTextViewB.backgroundColor = UIColor.greenColor();
        }
        else if(options[2] == correctAnswer){
            self.optionTextViewC.backgroundColor = UIColor.greenColor();
        }
        else if(options[3] == correctAnswer){
            self.optionTextViewD.backgroundColor = UIColor.greenColor();
        }
    }
    
    
    // MARK: - IBActions and Selectors
    @IBAction func prevButtonPressed(sender: AnyObject) {
        if(questionIndex-1 >= 0){
            /* Reset option colours */
            self.optionTextViewA.backgroundColor = UIColor(red: 221.0/255.0, green: 236.0/255.0, blue: 235.0/255.0, alpha: 1.0);
            self.optionTextViewB.backgroundColor = UIColor(red: 221.0/255.0, green: 236.0/255.0, blue: 235.0/255.0, alpha: 1.0);
            self.optionTextViewC.backgroundColor = UIColor(red: 221.0/255.0, green: 236.0/255.0, blue: 235.0/255.0, alpha: 1.0);
            self.optionTextViewD.backgroundColor = UIColor(red: 221.0/255.0, green: 236.0/255.0, blue: 235.0/255.0, alpha: 1.0);
            
            /* Load question */
            loadQuestionForIndex(--questionIndex);
        }
    }
    
    @IBAction func nextButtonPressed(sender: AnyObject) {
        if(questionIndex+1 < self.questions.count){
            /* Reset option colours */
            self.optionTextViewA.backgroundColor = UIColor(red: 221.0/255.0, green: 236.0/255.0, blue: 235.0/255.0, alpha: 1.0);
            self.optionTextViewB.backgroundColor = UIColor(red: 221.0/255.0, green: 236.0/255.0, blue: 235.0/255.0, alpha: 1.0);
            self.optionTextViewC.backgroundColor = UIColor(red: 221.0/255.0, green: 236.0/255.0, blue: 235.0/255.0, alpha: 1.0);
            self.optionTextViewD.backgroundColor = UIColor(red: 221.0/255.0, green: 236.0/255.0, blue: 235.0/255.0, alpha: 1.0);
            
            /* Load question */
            loadQuestionForIndex(++questionIndex);
        }
    }
    
    
    @IBAction func submitButtonPressed(sender: AnyObject) {
        self.dismissViewControllerAnimated(true, completion: nil);
    }

    
    override func prefersStatusBarHidden() -> Bool {
        return true;
    }
    

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
